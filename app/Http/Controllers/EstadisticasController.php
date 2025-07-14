<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use App\Models\User;
use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
    // 📊 Membresías activas vs vencidas
    public function membresiasEstado()
    {
        $hoy = now()->toDateString();

        $activas = User::whereHas('membresia', function ($q) use ($hoy) {
            $q->where('fecha_fin', '>=', $hoy);
        })->count();

        $vencidas = User::whereHas('membresia', function ($q) use ($hoy) {
            $q->where('fecha_fin', '<', $hoy);
        })->count();

        return response()->json([
            'activas' => $activas,
            'vencidas' => $vencidas,
        ]);
    }

    // 📊 Clases por profesor
    public function clasesPorProfesor()
    {
        $clases = Clase::select('instructor', DB::raw('count(*) as total'))
            ->groupBy('instructor')
            ->get();

        return response()->json($clases);
    }
}
