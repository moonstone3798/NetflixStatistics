<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');
// Configurar CORS correctamente
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 86400"); // 1 día
try {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

        if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido o no proporcionado']);
            exit;
        }

        $id = (int)$_GET['id'];

        $sql = "DELETE FROM usuarios WHERE id_usuario = $id";
        $res = mysqli_query($cnx, $sql);

        if ($res) {
            if (mysqli_affected_rows($cnx) > 0) {
                echo json_encode(['mensaje' => 'Usuario eliminado correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró un usuario con ese ID']);
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
