<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netflix_statistics";

$cnx = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
  echo "Conexión fallida: " . mysqli_connect_error();
  exit();
}
?>