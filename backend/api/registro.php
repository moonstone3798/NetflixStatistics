<?php
require './config/conexion.php';

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$mail = $_POST["mail"];
$constraenia = $_POST["constraenia"];
$avatar = null;

$sql = "SELECT * FROM usuarios WHERE mail = $email";
$res = mysqli_query($cnx,$sql);

if (mysqli_num_rows($res) == 1) {
    //ya existe ese mail registrado
    $response = array("status" => "error", "message" => "Ya existe una cuenta registrada con ese mail.");
    echo json_encode($response);
    
} else {
    // puede crear el usuario 
    $insert = "INSERT INTO usuario 
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