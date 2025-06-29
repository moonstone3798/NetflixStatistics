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

        // Debug temporal:
        error_log("Datos recibidos: " . print_r($data, true));

        $popularidad = isset($data['popularidad']) ? trim($data['popularidad']) : null;
        $votos = isset($data['votos']) ? trim($data['votos']) : null;
        $rating = isset($data['rating']) ? trim($data['rating']) : null;
        $promedio_votos = isset($data['promedio_votos']) ? trim($data['promedio_votos']) : null;
        $presupuesto = isset($data['presupuesto']) ? trim($data['presupuesto']) : null;
        $ganancias = isset($data['ganancias']) ? trim($data['ganancias']) : null;

        if (is_null($popularidad) || is_null($votos) || is_null($rating) || is_null($promedio_votos) || is_null($presupuesto) || is_null($ganancias)) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $popularidad = mysqli_real_escape_string($cnx, $popularidad);
        $votos = mysqli_real_escape_string($cnx, $votos);
        $rating = mysqli_real_escape_string($cnx, $rating);
        $promedio_votos = mysqli_real_escape_string($cnx, $promedio_votos);
        $presupuesto = mysqli_real_escape_string($cnx, $presupuesto);
        $ganancias = mysqli_real_escape_string($cnx, $ganancias);

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
                ganancias = $ganancias";
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
        "message" => "Error en el get datos_extras",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
