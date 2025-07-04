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

        $id_tipo = (int)$data['id_tipo'];
        $id_query = (int)$data['id_query'];


        if (!$id_tipo || !$id_query) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id_tipo = mysqli_real_escape_string($cnx, $id_tipo);
        $id_query = mysqli_real_escape_string($cnx, $id_query);

        $verifica_sql = "SELECT id_grafico FROM graficos WHERE grafico = '$grafico' ";
        $verifica_res = mysqli_query($cnx, $verifica_sql);

        if (mysqli_num_rows($verifica_res) > 0) {
            http_response_code(409);
            echo json_encode(['error' => 'Ya existe un grafico con ese query']);
            exit;
        }

        $sql = "INSERT INTO graficos SET 
                id_tipo = $id_tipo,
                id_query = $id_query
                ";
        $res = mysqli_query($cnx, $sql);

        if ($res) {
            http_response_code(201);
            echo json_encode([
                'mensaje' => 'grafico creado correctamente',
                'id_insertado' => mysqli_insert_id($cnx)
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => 'Error al insertar el grafico',
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
        "message" => "Error en el get graficos",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
