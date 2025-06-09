<?php
require '../config/conexion.php';

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

if (!isset($data["nombre"]) || !isset($data["apellido"]) || !isset($data["mail"]) || !isset($data["constraenia"])) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit;
}

$nombre = $data["nombre"];
$apellido = $data["apellido"];
$mail = $data["mail"];
$constraenia = $data["constraenia"];
$hashedPassword = password_hash($constraenia, PASSWORD_DEFAULT);
$avatar = null;

$sql = "SELECT * FROM usuarios WHERE mail = '".mysqli_real_escape_string($cnx, $mail)."' ";
$res = mysqli_query($cnx,$sql);

if (mysqli_num_rows($res) == 1) {
    //ya existe ese mail registrado
    $response = array("status" => "error", "message" => "Ya existe una cuenta registrada con ese mail.");
    echo json_encode($response);
    
} else {
    // puede crear el usuario 
    $insert = "INSERT INTO usuarios 
    SET nombre = '".mysqli_real_escape_string($cnx, $nombre)."',
    apellido = '".mysqli_real_escape_string($cnx, $apellido)."',
    mail = '".mysqli_real_escape_string($cnx, $mail)."',
    constraenia = '".mysqli_real_escape_string($cnx, $hashedPassword)."',
    is_admin = 0,
    avatar = $avatar";
    mysqli_query($cnx,$insert);

    $response = array("status" => "success", "message" => "Cuenta creada exitosamente!");
    echo json_encode($response);
}
?>