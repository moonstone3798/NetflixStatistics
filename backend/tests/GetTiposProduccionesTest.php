<?php

use PHPUnit\Framework\TestCase;

class GetTiposProduccionesTest extends TestCase
{
    private string $baseUrl = 'http://localhost/netflix/NetflixStatistics/backend/api/tipos_producciones/get_tipos_produccion.php';

    public function testGetAllTypeReturnsJsonArray()
    {
        $response = file_get_contents($this->baseUrl);
        $this->assertNotFalse($response, "La respuesta no debe ser falsa");

        $data = json_decode($response, true);
        $this->assertIsArray($data, "La respuesta debería ser un array JSON");

        if (!empty($data)) {
            $this->assertArrayHasKey('id', $data[0], "Falta clave 'id'");
        }
    }

    public function testGetTypeByIdReturnsSingleResult()
    {
        $id = 1; 
        $response = file_get_contents($this->baseUrl . '?id=' . $id);
        $this->assertNotFalse($response, "La respuesta no debe ser falsa");

        $data = json_decode($response, true);
        $this->assertIsArray($data, "La respuesta debe ser un array");

        $this->assertCount(1, $data, "Debería retornar un solo tipo de producción");
        $this->assertEquals($id, $data[0]['id'], "El ID del tipo de producción no coincide");
    }

    public function testGetTypeWithInvalidIdReturns400()
    {
        $url = $this->baseUrl . '?id=abc'; 
        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $response = file_get_contents($url, false, $context);

        preg_match('/HTTP\/\d\.\d\s(\d{3})/', $http_response_header[0], $matches);
        $statusCode = (int)($matches[1] ?? 0);

        $this->assertEquals(400, $statusCode, "Debe devolver código 400 para ID inválido");

        $data = json_decode($response, true);
        $this->assertArrayHasKey('error', $data, "Debe contener un mensaje de error");
    }
}
