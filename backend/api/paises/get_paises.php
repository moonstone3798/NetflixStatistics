<?php
require __DIR__ . '/../../config/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        if (is_numeric($_GET['id'])){
            $id = mysqli_real_escape_string($cnx, $_GET['id']);
            $sql = "SELECT * FROM paises WHERE id_pais = $id";
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido']);
            exit;
        }
        
    } else {
        $sql = "SELECT * FROM paises";
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

mysqli_close($cnx);
?>