<?php
require '../config/conexion.php';

// Configurar CORS correctamente
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 86400"); // 1 día

// Si es preflight, respondemos sin más
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Activar modo de excepciones en MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["nombre"], $data["apellido"], $data["mail"], $data["contrasenia"], $data["is_admin"])) {
        throw new Exception("Datos incompletos");
    }

    $nombre = mysqli_real_escape_string($cnx, $data["nombre"]);
    $apellido = mysqli_real_escape_string($cnx, $data["apellido"]);
    $mail = mysqli_real_escape_string($cnx, $data["mail"]);
    $contrasenia = mysqli_real_escape_string($cnx, $data["contrasenia"]);
    $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT);
    $is_admin = mysqli_real_escape_string($cnx, $data["is_admin"]);

    // Verificar si el usuario ya existe
    $sql = "SELECT * FROM usuarios WHERE mail = '$mail'";
    $res = mysqli_query($cnx, $sql);

    if (mysqli_num_rows($res) > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Ya existe una cuenta registrada con ese mail."
        ]);
        exit();
    }

    // Insertar nuevo usuario
    $insert = "INSERT INTO usuarios (nombre, apellido, mail, contrasenia, is_admin, avatar)
               VALUES ('$nombre', '$apellido', '$mail', '$hashedPassword', $is_admin, NULL)";
    
    mysqli_query($cnx, $insert);

    $id = mysqli_insert_id($cnx);

    echo json_encode([
        "status" => "success",
         "message" => "Cuenta creada exitosamente!",
         "id_usuario" => $id
        ]);

} catch (Exception $e) {
    // Capturar cualquier error del flujo o de MySQL
    echo json_encode([
        "status" => "error",
        "message" => "Error en el registro",
        "error" => $e->getMessage()
    ]);
}

mysqli_close($cnx);
?>
