<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID inválido o no proporcionado']);
        exit;
    }

    $id = (int)$_GET['id'];

    $sql = "DELETE FROM repartos WHERE id_reparto = $id";
    $res = mysqli_query($cnx, $sql);

    if ($res) {
        if (mysqli_affected_rows($cnx) > 0) {
            echo json_encode(['mensaje' => 'Reparto eliminado correctamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No se encontró un reparto con ese ID']);
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

mysqli_close($cnx);
?>
