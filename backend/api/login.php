<?php
require './config/conexion.php';

$mail = $_POST["mail"];
$constraenia = $_POST["constraenia"];

$sql = "SELECT * FROM usuarios WHERE mail = $mail";
$res = mysqli_query($cnx, $sql);

if (mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_array($res);
    if (password_verify($constraenia, $row["constraenia"])) {
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

mysqli_close($cnx)
?>