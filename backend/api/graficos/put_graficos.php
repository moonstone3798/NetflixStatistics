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
        $id_tipo = (int)$data['id_tipo'];
        $id_query = (int)$data['id_query'];

        if (!$id || !$id_tipo || !$id_query ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id = mysqli_real_escape_string($cnx, $id);
        $id_tipo = mysqli_real_escape_string($cnx, $id_tipo);
        $id_query = mysqli_real_escape_string($cnx, $id_query);

        $sql = "UPDATE graficos SET 
                id_tipo = $id_tipo,
                id_query = $id_query
                WHERE id_grafico = $id";

        $res = mysqli_query($cnx, $sql);

        if ($res) {
            if (mysqli_affected_rows($cnx) > 0) {
                echo json_encode(['mensaje' => 'grafico actualizado correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró un grafico con ese ID']);
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
        "message" => "Error en el get grafico",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
