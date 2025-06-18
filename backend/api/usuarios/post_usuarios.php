<?php
require __DIR__ . '/../../config/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $nombre = isset($data['nombre']) ? trim($data['nombre']) : null;
    $apellido = isset($data['apellido']) ? trim($data['apellido']) : null;
    $mail = isset($data['mail']) ? trim($data['mail']) : null;
    $contrasenia = isset($data['contrasenia']) ? trim($data['contrasenia']) : null;
    $is_admin = isset($data['is_admin']) ? trim($data['is_admin']) : null;
    $avatar = isset($data['avatar']) ? trim($data['avatar']) : null;

    if (!$nombre) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan campos requeridos']);
        exit;
    }

    $nombre = mysqli_real_escape_string($cnx, $nombre);

    // Verificar si ya existe
    $verifica_sql = "SELECT id_usuario FROM usuarios WHERE nombre = '$nombre' ";
    $verifica_res = mysqli_query($cnx, $verifica_sql);

    if (mysqli_num_rows($verifica_res) > 0) {
        http_response_code(409); // Conflict
        echo json_encode(['error' => 'Ya existe un usuario con ese nombre']);
        exit;
    }

    $sql = "INSERT INTO usuarios 
            SET nombre = '$nombre' 
            , apellido = '$apellido'
            , mail = '$mail'
            , contrasenia = '$contrasenia'
            , is_admin = $is_admin
            , avatar = '$avatar'";
    $res = mysqli_query($cnx, $sql);

    if ($res) {
        http_response_code(201);
        echo json_encode([
            'mensaje' => 'Usuario creado correctamente',
            'id_insertado' => mysqli_insert_id($cnx)
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => 'Error al insertar la producción',
            'detalle' => mysqli_error($cnx)
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}

mysqli_close($cnx);
?>
