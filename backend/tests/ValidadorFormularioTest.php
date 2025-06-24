<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/ValidadorFormulario.php';

class ValidadorFormularioTest extends TestCase {

    public function testEmailSinFormato() {
        $email = "correo_sin_arroba";
        $resultado = ValidadorFormulario::validarEmail($email);
        $this->assertFalse($resultado, "Debe rechazar un email sin formato válido");
    }

    public function testEmailValido() {
        $email = "brian@test.com";
        $resultado = ValidadorFormulario::validarEmail($email);
        $this->assertTrue($resultado, "Debe aceptar un email con formato válido");
    }
}
