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

        $popularidad = isset($data['popularidad']) ? trim($data['popularidad']) : null;
        $votos = isset($data['votos']) ? trim($data['votos']) : null;
        $rating = isset($data['rating']) ? trim($data['rating']) : null;
        $promedio_votos = isset($data['promedio_votos']) ? trim($data['promedio_votos']) : null;
        $presupuesto = isset($data['presupuesto']) ? trim($data['presupuesto']) : null;
        $ganancia = isset($data['ganancia']) ? trim($data['ganancia']) : null;

        if (!$popularidad || !$votos || !$rating || $promedio_votos || !$presupuesto || $ganancia ) {
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

        // Verificar si ya existe
        /*$verifica_sql = "SELECT id_dato_extra FROM datos_extras WHERE nombre = '$nombre' ";
        $verifica_res = mysqli_query($cnx, $verifica_sql);

        if (mysqli_num_rows($verifica_res) > 0) {
            http_response_code(409); // Conflict
            echo json_encode(['error' => 'Ya existe una producción con ese título y año']);
            exit;
        }*/

        $sql = "INSERT INTO datos_extras 
                SET popularidad = $popularidad,
                votos = $votos,
                rating = $rating,
                promedio_votos = $promedio_votos,
                presupuesto = $presupuesto,
                ganancia = $ganancia";
        $res = mysqli_query($cnx, $sql);

        if ($res) {
            http_response_code(201);
            echo json_encode([
                'mensaje' => 'datos extras creado correctamente',
                'id_insertado' => mysqli_insert_id($cnx)
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => 'Error al insertar el datos extras',
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
        "message" => "Error en el post datos datos extras",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
