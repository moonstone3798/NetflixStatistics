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
        $id_tipo = isset($data['id_tipo']) ? trim($data['id_tipo']) : null;
        $id_usuario = isset($data['id_usuario']) ? trim($data['id_usuario']) : null;
        $id_query = isset($data['id_query']) ? trim($data['id_query']) : null;

        if ( is_null($nombre) || is_null($id_tipo) || is_null($id_usuario) ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $nombre = mysqli_real_escape_string($cnx, $nombre);
        $id_tipo = (int)$id_tipo;
        $id_usuario = (int)$id_usuario;
        $id_query = (int)$id_query;

        $verifica_sql = "SELECT id_vista FROM vistas WHERE nombre = '$nombre' ";
        $verifica_res = mysqli_query($cnx, $verifica_sql);

        if (mysqli_num_rows($verifica_res) > 0) {
            http_response_code(409);
            echo json_encode(['error' => 'Ya existe un vista con ese query']);
            exit;
        }

        $sql = "INSERT INTO vistas SET 
                nombre = '$nombre',
                id_tipo = $id_tipo,
                id_usuario = $id_usuario,
                id_query = $id_query
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
        "message" => "Error en el post vistas",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
