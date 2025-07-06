<?php

namespace App\Http\Controllers;

use App\Models\SolicitudClase;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;

class SolicitudClaseController extends Controller
{
    // 1️⃣ Cliente envía solicitud
    public function store(Request $request)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id',
            'cliente_id' => 'required|exists:users,id',
        ]);

        $existe = SolicitudClase::where('clase_id', $request->clase_id)
            ->where('cliente_id', $request->cliente_id)
            ->whereIn('estado', ['pendiente', 'aceptada'])
            ->exists();

        if ($existe) {
            return response()->json(['mensaje' => 'Ya has enviado una solicitud para esta clase.'], 409);
        }

        $solicitud = SolicitudClase::create([
            'clase_id' => $request->clase_id,
            'cliente_id' => $request->cliente_id,
            'estado' => 'pendiente',
        ]);

        return response()->json(['mensaje' => 'Solicitud enviada correctamente', 'solicitud' => $solicitud], 201);
    }

    // 2️⃣ Profesor consulta solicitudes pendientes
    public function porInstructor($instructor)
    {
        $clases = Clase::where('instructor', $instructor)->pluck('id');

        $solicitudes = SolicitudClase::with(['clase', 'cliente'])
            ->whereIn('clase_id', $clases)
            ->where('estado', 'pendiente')
            ->get();

        return response()->json($solicitudes);
    }

    // 3️⃣ Profesor actualiza estado (aceptar o rechazar)
    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:aceptada,rechazada',
        ]);

        $solicitud = SolicitudClase::findOrFail($id);
        $solicitud->estado = $request->estado;
        $solicitud->save();

        return response()->json(['mensaje' => 'Estado actualizado']);
    }

    // 4️⃣ Cliente ve clases aceptadas
    public function clasesAceptadasPorCliente($clienteId)
    {
        $solicitudes = SolicitudClase::where('cliente_id', $clienteId)
            ->where('estado', 'aceptada')
            ->with('clase')
            ->get();

        $clasesAceptadas = $solicitudes->pluck('clase');

        return response()->json($clasesAceptadas);
    }

    // 5️⃣ Actualizar estado con mensaje de rechazo
    public function actualizarEstadoSolicitud(Request $request, $id)
    {
        $solicitud = SolicitudClase::findOrFail($id);
        $solicitud->estado = $request->input('estado');

        if ($solicitud->estado == 'rechazada') {
            $solicitud->mensaje_cliente = "La clase fue rechazada. El cupo está lleno.";
            $solicitud->leido_cliente = false;
        }

        $solicitud->save();

        return response()->json(['success' => true]);
    }

    // 6️⃣ Mensajes de rechazo con nombre de clase incluido
    public function mensajesRechazo($clienteId)
    {
        $solicitudes = SolicitudClase::with('clase')
            ->where('cliente_id', $clienteId)
            ->where('estado', 'rechazada')
            ->where('leido_cliente', false)
            ->get();

        $mensajes = $solicitudes->map(function ($solicitud) {
            return [
                'id' => $solicitud->id,
                'mensaje_cliente' => $solicitud->mensaje_cliente,
                'clase_id' => $solicitud->clase_id,
                'nombre_clase' => optional($solicitud->clase)->nombre ?? 'Clase desconocida',
            ];
        });

        return response()->json($mensajes);
    }

    // 7️⃣ Marcar mensaje como leído
    public function marcarLeido($id)
    {
        $solicitud = SolicitudClase::findOrFail($id);
        $solicitud->leido_cliente = true;
        $solicitud->save();

        return response()->json(['success' => true]);
    }
}
