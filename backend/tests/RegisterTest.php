<?php

use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    private string $url = 'http://localhost/netflix/NetflixStatistics/backend/api/registro.php';

    private function sendPostRequest(array $data): array
    {
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n",
                'content' => json_encode($data),
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($this->url, false, $context);

        if ($response === false) {
            $error = error_get_last();
            $this->fail("Error en la solicitud HTTP: " . $error['message']);
        }

        echo "\nRespuesta cruda:\n$response\n";

        return json_decode($response, true);
    }

    protected function setUp(): void
    {
        $cnx = new mysqli("localhost", "root", "", "netflix_statistics");
        $cnx->query("DELETE FROM usuarios WHERE mail = 'nuevo@ejemplo.com'");
        $cnx->close();
    }

    public function testRegistroExitoso()
    {
        $payload = [
            "nombre" => "Nuevo",
            "apellido" => "Usuario",
            "mail" => "nuevo@ejemplo.com",
            "contrasenia" => "123456",
            "is_admin" => 0
        ];

        $json = $this->sendPostRequest($payload);

        $this->assertEquals("success", $json["status"]);
        $this->assertEquals("Cuenta creada exitosamente!", $json["message"]);
    }

    public function testRegistroConMailExistente()
    {
        $cnx = new mysqli("localhost", "root", "", "netflix_statistics");
        $hash = password_hash("123456", PASSWORD_DEFAULT);
        $cnx->query("INSERT INTO usuarios (nombre, apellido, mail, contrasenia, is_admin, avatar)
                     VALUES ('Nuevo', 'Usuario', 'nuevo@ejemplo.com', '$hash', 0, NULL)");
        $cnx->close();

        $payload = [
            "nombre" => "Nuevo",
            "apellido" => "Usuario",
            "mail" => "nuevo@ejemplo.com",
            "contrasenia" => "123456",
            "is_admin" => 0
        ];

        $json = $this->sendPostRequest($payload);

        $this->assertEquals("error", $json["status"]);
        $this->assertEquals("Ya existe una cuenta registrada con ese mail.", $json["message"]);
    }

    public function testRegistroConDatosIncompletos()
    {
        $payload = [
            "nombre" => "FaltaMail",
            "apellido" => "Test",
            "contrasenia" => "123456",
            "is_admin" => 0
        ]; // falta "mail"

        $json = $this->sendPostRequest($payload);

        $this->assertEquals("error", $json["status"]);
        $this->assertEquals("Error en el registro", $json["message"]);
        $this->assertStringContainsString("Datos incompletos", $json["error"]);
    }
}
