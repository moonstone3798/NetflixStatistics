<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $nombre = isset($data['nombre']) ? trim($data['nombre']) : null;

    if (!$nombre) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan campos requeridos']);
        exit;
    }

    $nombre = mysqli_real_escape_string($cnx, $nombre);

    // Verificar si ya existe
    $verifica_sql = "SELECT id_pais FROM paises WHERE nombre = '$nombre' ";
    $verifica_res = mysqli_query($cnx, $verifica_sql);

    if (mysqli_num_rows($verifica_res) > 0) {
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'Ya existe una producción con ese título y año']);
        exit;
    }

    $sql = "INSERT INTO paises SET nombre = '$nombre' ";
    $res = mysqli_query($cnx, $sql);

    if ($res) {
        http_response_code(201);
        echo json_encode([
            'mensaje' => 'Producción creada correctamente',
            'id_insertado' => mysqli_insert_id($cnx)
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => 'Error al insertar la producción',
            'detalle' => mysqli_error($cnx)
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}

mysqli_close($cnx);
?>
