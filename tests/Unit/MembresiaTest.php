<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Membresia;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembresiaTest extends TestCase
{
    /** @test */
    public function membresia_creada_correctamente()
    {
        $membresia = Membresia::create([
            'tipo_membresia' => 'Prueba',
            'fecha_inicio' => '2025-06-20',
            'fecha_fin' => '2025-09-20',
        ]);

        $this->assertDatabaseHas('membresias', [
            'tipo_membresia' => 'Prueba',
            'fecha_inicio' => '2025-06-20',
            'fecha_fin' => '2025-09-20',
        ]);
    }
}
