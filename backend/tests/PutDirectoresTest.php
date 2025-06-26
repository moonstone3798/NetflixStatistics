<?php
use PHPUnit\Framework\TestCase;

class EditarDirectorTest extends TestCase
{
    private string $url = 'http://localhost/netflix/NetflixStatistics/backend/api/directores/put_directores.php';

    public function testEditarDirectorConDatosValidos()
    {
        $data = [
            'id' => 1,
            'nombre' => 'Nombre Actualizado'
        ];

        $payload = json_encode($data);

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(200, $httpcode, 'Debe devolver código 200');

        $json = json_decode($response, true);
        $this->assertArrayHasKey('mensaje', $json);
        $this->assertEquals('Director actualizado correctamente', $json['mensaje']);
    }
}
?>