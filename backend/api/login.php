<?php
require '../config/conexion.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Leer JSON desde el body
$input = json_decode(file_get_contents("php://input"), true);

// Validar campos
if (!isset($input["mail"]) || !isset($input["constraenia"])) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit;
}

$mail = $input["mail"];
$constraenia = $input["constraenia"];

$sql = "SELECT * FROM usuarios WHERE mail = '" . mysqli_real_escape_string($cnx, $mail) . "'";
$res = mysqli_query($cnx, $sql);

if (mysqli_num_rows($res) === 1) {
    $row = mysqli_fetch_assoc($res);

    // Comparar contraseña ingresada con la hasheada en la base de datos
    if (password_verify($constraenia, $row["constraenia"])) {
        echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Contraseña incorrecta"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
}

mysqli_close($cnx);
?>
