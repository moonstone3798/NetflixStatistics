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
        $id_idioma = (int)$data['id_idioma'];
        $id_datos_extras = (int)$data['id_datos_extras'];
        $id_tipo_produccion = (int)$data['id_tipo_produccion'];

        $titulo = isset($data['titulo']) ? trim($data['titulo']) : null;
        $fecha_ingreso = isset($data['fecha_ingreso']) ? trim($data['fecha_ingreso']) : null;
        $anio_realizacion = isset($data['anio_realizacion']) ? trim($data['anio_realizacion']) : null;
        $duracion = isset($data['duracion']) ? trim($data['duracion']) : null;
        $descripcion = isset($data['descripcion']) ? trim($data['descripcion']) : null;
        $id_idioma = isset($data['id_idioma']) ? trim($data['id_idioma']) : null;
        $id_datos_extras = isset($data['id_datos_extras']) ? trim($data['id_datos_extras']) : null;
        $id_tipo_produccion = isset($data['id_tipo_produccion']) ? trim($data['id_tipo_produccion']) : null;

        if (!$id_tipo_produccion || !$titulo || !$fecha_ingreso || !$duracion || !$descripcion || !$id_idioma || !$id_datos_extras) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $titulo = mysqli_real_escape_string($cnx, $titulo);
        $fecha_ingreso = mysqli_real_escape_string($cnx, $fecha_ingreso);
        $anio_realizacion = mysqli_real_escape_string($cnx, $anio_realizacion);
        $duracion = mysqli_real_escape_string($cnx, $duracion);
        $descripcion = mysqli_real_escape_string($cnx, $descripcion);
        $id_idioma = mysqli_real_escape_string($cnx, $id_idioma);
        $id_datos_extras = mysqli_real_escape_string($cnx, $id_datos_extras);
        $id_tipo_produccion = mysqli_real_escape_string($cnx, $id_tipo_produccion);

        $sql = "UPDATE producciones SET 
                titulo = '$titulo'
                , fecha_ingreso = '$fecha_ingreso'
                , anio_realizacion = '$anio_realizacion'
                , duracion = '$duracion'
                , descripcion = '$descripcion'
                , id_idioma = $id_idioma
                , id_datos_extras = $id_datos_extras
                , id_tipo = $id_tipo_produccion
                WHERE id_produccion = $id";

        $res = mysqli_query($cnx, $sql);

        if ($res) {
            if (mysqli_affected_rows($cnx) > 0) {
                echo json_encode(['mensaje' => 'Producción actualizada correctamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró una producción con ese ID']);
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
        "message" => "Error en la api put producciones",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
