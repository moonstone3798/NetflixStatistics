<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');
// Configurar CORS correctamente
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 86400"); // 1 día
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
        $idioma = isset($data['idioma']) ? trim($data['idioma']) : null;

        if (!$id || !$idioma ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id = mysqli_real_escape_string($cnx, $id);
        $idioma = mysqli_real_escape_string($cnx, $idioma);

        $sql = "UPDATE idiomas 
                SET idioma = '$idioma'
                WHERE id_idioma = $id";

        $res = mysqli_query($cnx, $sql);

        if ($res) {
            if (mysqli_affected_rows($cnx) > 0) {
                echo json_encode(['mensaje' => 'Idioma actualizado correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró un idioma con ese ID']);
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
        "message" => "Error en el get directores",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
