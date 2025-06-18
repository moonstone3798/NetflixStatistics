<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $idioma = isset($data['idioma']) ? trim($data['idioma']) : null;

    if (!$nombre) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan campos requeridos']);
        exit;
    }

    $idioma = mysqli_real_escape_string($cnx, $idioma);

    // Verificar si ya existe
    $verifica_sql = "SELECT id_idioma FROM idiomas WHERE idioma = '$idioma' ";
    $verifica_res = mysqli_query($cnx, $verifica_sql);

    if (mysqli_num_rows($verifica_res) > 0) {
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'Ya existe una producción con ese título y año']);
        exit;
    }

    $sql = "INSERT INTO idiomas SET idioma = '$idioma' ";
    $res = mysqli_query($cnx, $sql);

    if ($res) {
        http_response_code(201);
        echo json_encode([
            'mensaje' => 'Idioma creado correctamente',
            'id_insertado' => mysqli_insert_id($cnx)
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => 'Error al insertar el idioma',
            'detalle' => mysqli_error($cnx)
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}

mysqli_close($cnx);
?>
