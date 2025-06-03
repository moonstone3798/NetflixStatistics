<?php
$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM usuarios WHERE mail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["contrasena"])) {
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

$stmt->close();
$conn->close();
?>