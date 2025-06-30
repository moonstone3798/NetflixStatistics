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

        $titulo = isset($data['titulo']) ? trim($data['titulo']) : null;
        $fecha_ingreso = isset($data['fecha_ingreso']) ? trim($data['fecha_ingreso']) : null;
        $anio_realizacion = isset($data['anio_realizacion']) ? trim($data['anio_realizacion']) : null;
        $duracion = isset($data['duracion']) ? trim($data['duracion']) : null;
        $descripcion = isset($data['descripcion']) ? trim($data['descripcion']) : null;
        $id_idioma = isset($data['id_idioma']) ? trim($data['id_idioma']) : null;
        $id_datos_extras = isset($data['id_datos_extras']) ? trim($data['id_datos_extras']) : null;
        $id_tipo_produccion = isset($data['id_tipo_produccion']) ? trim($data['id_tipo_produccion']) : null;

        if ( !$titulo || !$fecha_ingreso || !$duracion || !$descripcion || !$id_idioma || !$id_datos_extras || !$id_tipo_produccion) {
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

        // Verificar si ya existe
        $verifica_sql = "SELECT id_produccion FROM producciones WHERE titulo = '$titulo' ";
        $verifica_res = mysqli_query($cnx, $verifica_sql);

        if (mysqli_num_rows($verifica_res) > 0) {
            http_response_code(409); // Conflict
            echo json_encode(['mensaje' => 'Ya existe una producción con ese título']);
            exit;
        }

        $sql = "INSERT INTO producciones SET 
                titulo = '$titulo'
                , fecha_ingreso = '$fecha_ingreso'
                , anio_realizacion = '$anio_realizacion'
                , duracion = '$duracion'
                , descripcion = '$descripcion'
                , id_idioma = $id_idioma
                , id_datos_extras = $id_datos_extras
                , id_tipo = $id_tipo_produccion
                ";
        $res = mysqli_query($cnx, $sql);

        if ($res) {
            http_response_code(201);
            echo json_encode([
                'mensaje' => 'Producción creada correctamente',
                'id_insertado' => mysqli_insert_id($cnx)
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'mensaje' => 'Error al insertar la producción',
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
        "message" => "Error en la api post producciones",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>
