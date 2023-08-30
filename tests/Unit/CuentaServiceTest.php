<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CuentaService;
use App\Models\Cuenta;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CuentaServiceTest extends TestCase
{
    use RefreshDatabase; // Restaura la base de datos después de cada prueba

    protected $cuentaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cuentaService = new CuentaService();
    }

    public function testCreateCuenta()
    {
        $data = [
            'nombre' => 'John Doe',
            'email' => 'john@example.com',
            'telefono' => '123456789'
        ];

        $cuenta = $this->cuentaService->createCuenta($data);
        $this->assertInstanceOf(Cuenta::class, $cuenta);
        $this->assertDatabaseHas('cuentas', $data);
    }
}
