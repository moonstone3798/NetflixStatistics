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
        $popularidad = isset($data['popularidad']) ? trim($data['popularidad']) : null;
        $votos = isset($data['votos']) ? trim($data['votos']) : null;
        $rating = isset($data['rating']) ? trim($data['rating']) : null;
        $promedio_votos = isset($data['promedio_votos']) ? trim($data['promedio_votos']) : null;
        $presupuesto = isset($data['presupuesto']) ? trim($data['presupuesto']) : null;
        $ganancia = isset($data['ganancia']) ? trim($data['ganancia']) : null;

        if ( !$id || !$popularidad || !$votos || !$rating || !$promedio_votos || !$presupuesto || !$ganancia ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $popularidad = mysqli_real_escape_string($cnx, $popularidad);
        $votos = mysqli_real_escape_string($cnx, $votos);
        $rating = mysqli_real_escape_string($cnx, $rating);
        $promedio_votos = mysqli_real_escape_string($cnx, $promedio_votos);
        $presupuesto = mysqli_real_escape_string($cnx, $presupuesto);
        $ganancia = mysqli_real_escape_string($cnx, $ganancia);

        $sql = "UPDATE datos_extras 
                SET popularidad = $popularidad,
                votos = $votos,
                rating = $rating,
                promedio_votos = $promedio_votos,
                presupuesto = $presupuesto,
                ganancia = $ganancia
                WHERE id_dato_extra = $id";

        $res = mysqli_query($cnx, $sql);

        if ($res) {
            if (mysqli_affected_rows($cnx) > 0) {
                echo json_encode(['mensaje' => 'datos extras actualizada correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró un datos_extras con ese ID']);
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
        "message" => "Error en el api datos extras put",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
