<?php
namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\SolicitudClase;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    public function index()
    {
        return response()->json(Clase::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nivel' => 'required|string|max:50',
            'dia' => 'required|string|max:50',
            'hora' => 'required|string|max:20',
            'instructor' => 'required|string|max:255',
        ]);

        $clase = Clase::create($request->all());

        return response()->json($clase, 201);
    }

    public function show($id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json(['error' => 'Clase no encontrada'], 404);
        }

        return response()->json($clase);
    }

    public function update(Request $request, $id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json(['error' => 'Clase no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'nivel' => 'sometimes|required|string|max:50',
            'dia' => 'sometimes|required|string|max:50',
            'hora' => 'sometimes|required|string|max:20',
            'instructor' => 'sometimes|required|string|max:255',
        ]);

        $clase->update($request->all());

        return response()->json($clase);
    }

    public function destroy($id)
    {
        $clase = Clase::find($id);

        if (!$clase) {
            return response()->json(['error' => 'Clase no encontrada'], 404);
        }

        $clase->delete();

        return response()->json(['message' => 'Clase eliminada correctamente']);
    }

    public function getClasesByInstructor($nombreInstructor)
    {
        $clases = Clase::where('instructor', $nombreInstructor)->get();

        if ($clases->isEmpty()) {
            return response()->json(['message' => 'No se encontraron clases para este instructor.'], 404);
        }

        return response()->json($clases);
    }

    // ✅ Método nuevo: Clases aceptadas por cliente
    public function aceptadasPorCliente($cliente_id)
    {
        $solicitudes = SolicitudClase::where('cliente_id', $cliente_id)
            ->where('estado', 'aceptada')
            ->with('clase')
            ->get();

        $clasesAceptadas = $solicitudes->pluck('clase')->filter(); // Filtra nulos por si alguna clase fue eliminada

        return response()->json($clasesAceptadas->values());
    }
}
