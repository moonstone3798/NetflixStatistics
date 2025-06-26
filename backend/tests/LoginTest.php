<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private string $url = 'http://localhost/netflix/NetflixStatistics/backend/api/login.php';

    public function testLoginExitoso()
    {
        $data = [
            'mail' => 'nadiradad@gmail.com',
            'contrasenia' => 'nadir123'  
        ];

        $response = $this->sendPostRequest($data);
        $json = json_decode($response, true);

        $this->assertEquals('success', $json['status']);
        $this->assertArrayHasKey('data', $json);
        $this->assertEquals('nadiradad@gmail.com', $json['data']['mail']);
    }

    public function testLoginConPasswordIncorrecta()
    {
        $data = [
            'mail' => 'nadiradad@gmail.com',
            'contrasenia' => 'nose'
        ];

        $response = $this->sendPostRequest($data);
        $json = json_decode($response, true);

        $this->assertEquals('error', $json['status']);
        $this->assertEquals('Contraseña incorrecta', $json['message']);
    }

    public function testLoginConUsuarioInexistente()
    {
        $data = [
            'mail' => 'noexiste@fake.com',
            'contrasenia' => 'loquesea'
        ];

        $response = $this->sendPostRequest($data);
        $json = json_decode($response, true);

        $this->assertEquals('error', $json['status']);
        $this->assertEquals('Usuario no encontrado', $json['message']);
    }

    private function sendPostRequest(array $data): string
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

        // Agregar salida para debug
        if ($response === false) {
            $error = error_get_last();
            $this->fail("Error al hacer la solicitud: " . $error['message']);
        }

        echo "\nRespuesta cruda:\n$response\n"; 
        return $response;
    }

}
