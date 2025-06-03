<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netflix_statistics";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Cierra la conexión cuando hayas terminado
//$conn->close();
?>