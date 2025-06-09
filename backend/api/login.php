<?php

require './config/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

// Permitir CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Manejo del preflight (solicitud OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if (!isset($_POST["mail"]) || !isset($_POST["constraenia"])) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit;
}

$mail = $_POST["mail"];
$constraenia = $_POST["constraenia"];

$sql = "SELECT * FROM usuarios WHERE mail = '".mysqli_real_escape_string($cnx, $mail)."' ";
$res = mysqli_query($cnx, $sql);

if (mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_array($res);
    //if (password_verify($constraenia, $row["constraenia"])) {
    if ($constraenia === $row["constraenia"]) {
        // Inicio de sesión exitoso
        $response = array("status" => "success", "message" => "Inicio de sesión exitoso");
        echo json_encode($response);
    } else {
        // Contraseña incorrecta
        $response = array("status" => "error", "message" => "Contraseña incorrecta");
        echo json_encode($response);
    }
} else {
    // Usuario no encontrado
    $response = array("status" => "error", "message" => "Usuario no encontrado");
    echo json_encode($response);
}

mysqli_close($cnx);
?>