<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 86400");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
try {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;

        if (is_null($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido o no proporcionado']);
            exit;
        }

        $sql = "DELETE FROM tipos_produccion WHERE id_tipo_produccion = $id";
        $res = mysqli_query($cnx, $sql);

        if ($res) {
            if (mysqli_affected_rows($cnx) > 0) {
                echo json_encode(['mensaje' => 'Tipo producción eliminado correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró un tipo produccion con ese ID']);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => 'Error al ejecutar la consulta',
                'detalle' => mysqli_error($cnx)
            ]);
        }
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    // Capturar cualquier error del flujo o de MySQL
    echo json_encode([
        "status" => "error",
        "message" => "Error en el get directores",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
