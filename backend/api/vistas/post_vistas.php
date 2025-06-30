<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 86400");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $nombre = isset($data['nombre']) ? trim($data['nombre']) : null;
        $id_grafico = (int)$data['id_grafico'];
        $id_usuario = (int)$data['id_usuario'];

        if ( !$nombre || !$id_usuario || $id_grafico ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $nombre = mysqli_real_escape_string($cnx, $nombre);
        $id_grafico = mysqli_real_escape_string($cnx, $id_grafico);
        $id_usuario = mysqli_real_escape_string($cnx, $id_usuario);

        $verifica_sql = "SELECT id_vista FROM vistas WHERE vista = '$vista' ";
        $verifica_res = mysqli_query($cnx, $verifica_sql);

        if (mysqli_num_rows($verifica_res) > 0) {
            http_response_code(409);
            echo json_encode(['error' => 'Ya existe un vista con ese query']);
            exit;
        }

        $sql = "INSERT INTO vistas SET 
                nombre = $nombre,
                id_grafico = $id_grafico,
                id_usuario = $id_usuario
                ";
        $res = mysqli_query($cnx, $sql);

        if ($res) {
            http_response_code(201);
            echo json_encode([
                'mensaje' => 'vista creado correctamente',
                'id_insertado' => mysqli_insert_id($cnx)
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => 'Error al insertar el vista',
                'detalle' => mysqli_error($cnx)
            ]);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error en el get vistas",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
