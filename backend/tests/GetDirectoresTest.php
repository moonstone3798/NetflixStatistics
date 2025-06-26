<?php

use PHPUnit\Framework\TestCase;

class GetDirectoresTest extends TestCase
{
    private string $baseUrl = 'http://localhost/netflix/NetflixStatistics/backend/api/directores/get_directores.php';

    public function testGetAllDirectoresReturnsJsonArray()
    {
        $response = file_get_contents($this->baseUrl);
        $this->assertNotFalse($response, "La respuesta no debe ser falsa");

        $data = json_decode($response, true);
        $this->assertIsArray($data, "La respuesta debería ser un array JSON");

        if (!empty($data)) {
            $this->assertArrayHasKey('id_director', $data[0], "Falta clave 'id_director'");
        }
    }

    public function testGetDirectorByIdReturnsSingleResult()
    {
        $id = 1; // Cambia por un ID válido en tu base de datos de prueba
        $response = file_get_contents($this->baseUrl . '?id=' . $id);
        $this->assertNotFalse($response, "La respuesta no debe ser falsa");

        $data = json_decode($response, true);
        $this->assertIsArray($data, "La respuesta debe ser un array");

        $this->assertCount(1, $data, "Debería retornar un solo director");
        $this->assertEquals($id, $data[0]['id_director'], "El ID del director no coincide");
    }

    public function testGetDirectorWithInvalidIdReturns400()
    {
        $url = $this->baseUrl . '?id=abc'; // ID inválido
        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $response = file_get_contents($url, false, $context);

        // Extraemos el código HTTP
        preg_match('/HTTP\/\d\.\d\s(\d{3})/', $http_response_header[0], $matches);
        $statusCode = (int)($matches[1] ?? 0);

        $this->assertEquals(400, $statusCode, "Debe devolver código 400 para ID inválido");

        $data = json_decode($response, true);
        $this->assertArrayHasKey('error', $data, "Debe contener un mensaje de error");
    }
}
