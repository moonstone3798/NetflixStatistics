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

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$mail = $_POST["mail"];
$constraenia = $_POST["constraenia"];
$avatar = null;

$sql = "SELECT * FROM usuarios WHERE mail = '".mysqli_real_escape_string($cnx, $email)."' ";
$res = mysqli_query($cnx,$sql);

if (mysqli_num_rows($res) == 1) {
    //ya existe ese mail registrado
    $response = array("status" => "error", "message" => "Ya existe una cuenta registrada con ese mail.");
    echo json_encode($response);
    
} else {
    // puede crear el usuario 
    $insert = "INSERT INTO usuarios 
    SET nombre = $nombre,
    apellido = $apellido,
    email = $email,
    constraenia = $constraenia,
    is_admin = 0,
    avatar = $avatar";
    mysqli_query($cnx,$insert);

    $response = array("status" => "success", "message" => "Cuenta creada exitosamente!");
    echo json_encode($response);
}
?>