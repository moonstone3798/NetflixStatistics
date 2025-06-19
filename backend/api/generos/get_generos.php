<?php
require __DIR__ . '/../../config/conexion.php';

header('Content-Type: application/json');
// Configurar CORS correctamente
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 86400"); // 1 día
try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id'])) {
            if (is_numeric($_GET['id'])){
                $id = mysqli_real_escape_string($cnx, $_GET['id']);
                $sql = "SELECT * FROM generos WHERE id_genero = $id";
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID inválido']);
                exit;
            }
            
        } else {
            $sql = "SELECT * FROM generos";
        }

        $res = mysqli_query($cnx, $sql);

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
    // Capturar cualquier error del flujo o de MySQL
    echo json_encode([
        "status" => "error",
        "message" => "Error en el get directores",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>