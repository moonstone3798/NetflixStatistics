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
    // Leer JSON desde el body
    $input = json_decode(file_get_contents("php://input"), true);

    // Validar campos
    if (!isset($input["mail"]) || !isset($input["contrasenia"])) {
        echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
        exit;
    }

    $mail = $input["mail"];
    $contrasenia = $input["contrasenia"];

    $sql = "SELECT * FROM usuarios WHERE mail = '" . mysqli_real_escape_string($cnx, $mail) . "'";
    $res = mysqli_query($cnx, $sql);

    if (mysqli_num_rows($res) === 1) {
        $row = mysqli_fetch_assoc($res);

        // Comparar contraseña ingresada con la hasheada en la base de datos
        if (password_verify($contrasenia, $row["contrasenia"])) {
            echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
    }
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
