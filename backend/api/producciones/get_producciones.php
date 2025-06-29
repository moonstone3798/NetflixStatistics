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
                $sql = "SELECT p.id_produccion
                        , tp.nombre AS tipo_produccion
                        , p.titulo
                        , p.fecha_ingreso
                        , p.anio_realizacion
                        , p.duracion
                        , p.descripcion
                        , i.idioma
                        , de.popularidad
                        , de.votos
                        , de.rating
                        , de.promedio_votos
                        , de.presupuesto
                        , de.ganancia 
                        FROM producciones p
                        INNER JOIN idiomas i ON p.id_idioma = i.id_idioma
                        INNER JOIN datos_extras de ON p.id_datos_extras = de.id_dato_extra
                        INNER JOIN tipos_produccion tp ON p.id_tipo = tp.id_tipo_produccion
                        WHERE id_produccion = $id";
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID inválido']);
                exit;
            }
            
        } else {
            $sql = "SELECT p.id_produccion
                    , tp.nombre AS tipo_produccion
                    , p.titulo
                    , p.fecha_ingreso
                    , p.anio_realizacion
                    , p.duracion
                    , p.descripcion
                    , i.idioma
                    , de.popularidad
                    , de.votos
                    , de.rating
                    , de.promedio_votos
                    , de.presupuesto
                    , de.ganancia 
                    FROM producciones p
                    INNER JOIN idiomas i ON p.id_idioma = i.id_idioma
                    INNER JOIN datos_extras de ON p.id_datos_extras = de.id_dato_extra
                    INNER JOIN tipos_produccion tp ON p.id_tipo = tp.id_tipo_produccion";
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
        "message" => "Error en el get producciones",
        "error" => $e->getMessage()
    ]);
}
mysqli_close($cnx);
?>