<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Max-Age: 86400");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
try {
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        if (!isset($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido o no proporcionado']);
            exit;
        }

        $id = (int)$data['id'];
        $nombre = isset($data['nombre']) ? trim($data['nombre']) : null;
        $id_grafico = (int)$data['id_grafico'];
        $id_usuario = (int)$data['id_usuario'];

        if (!$id || !$nombre || !$id_usuario || $id_grafico ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id = mysqli_real_escape_string($cnx, $id);
        $nombre = mysqli_real_escape_string($cnx, $nombre);
        $id_grafico = mysqli_real_escape_string($cnx, $id_grafico);
        $id_usuario = mysqli_real_escape_string($cnx, $id_usuario);

        $sql = "UPDATE vistas SET 
                nombre = $nombre,
                id_grafico = $id_grafico,
                id_usuario = $id_usuario
                WHERE id_vista = $id";

        $res = mysqli_query($cnx, $sql);

        if ($res) {
            if (mysqli_affected_rows($cnx) > 0) {
                echo json_encode(['mensaje' => 'vista actualizado correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró un vista con ese ID']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al ejecutar la consulta']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    // Capturar cualquier error del flujo o de MySQL
    echo json_encode([
        "status" => "error",
        "message" => "Error en el get vista",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
