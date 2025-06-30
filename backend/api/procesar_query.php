<?php
require __DIR__ . '/../config/conexion.php';
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

        $query = isset($data['query']) ? trim($data['query']) : null;

        if ( !$query ) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $res = mysqli_query($cnx, $query);

        if ($res) {
            $datos = [];
            while ($fila = mysqli_fetch_assoc($res)) {
                $datos[] = $fila;
            }
            echo json_encode($datos);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al ejecutar la consulta']);
        }

    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error en la consulta estadística",
        "error" => $e->getMessage()
    ]);
}

mysqli_close($cnx);
