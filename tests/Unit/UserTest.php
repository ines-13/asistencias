<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /** @test */
    public function usuario_registrado_correctamente()
    {
        $usuario = User::create([
            'name' => 'Usuario Prueba',
            'email' => 'usuario@prueba.com',
            'password' => bcrypt('123456'),
            'ap_usuario' => 'Pérez',
            'am_usuario' => 'Sosa',
            'tel_cel_usuario' => '1234567890',
            'tel_emergencia' => '0987654321',
            'rfc' => 'PESJ920101XXX',
            'rol' => 'cliente',
            'notas_medicas' => 'Ninguna',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'usuario@prueba.com',
            'name' => 'Usuario Prueba',
        ]);
    }
}
