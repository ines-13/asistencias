<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->ap_usuario = $request->ap_usuario;
        $user->am_usuario = $request->am_usuario;
        $user->tel_cel_usuario = $request->tel_cel_usuario;
        $user->tel_emergencia = $request->tel_emergencia;
        $user->notas_medicas = $request->notas_medicas;
        $user->rfc = $request->rfc;
        $user->rol = $request->rol;
        $user->membresia_id = $request->membresia_id;
        $user->save();

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->ap_usuario = $request->ap_usuario;
        $user->am_usuario = $request->am_usuario;
        $user->tel_cel_usuario = $request->tel_cel_usuario;
        $user->tel_emergencia = $request->tel_emergencia;
        $user->notas_medicas = $request->notas_medicas;
        $user->rfc = $request->rfc;
        $user->rol = $request->rol;
        $user->membresia_id = $request->membresia_id;
        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['mensaje' => 'Usuario eliminado correctamente']);
    }

    // ✅ NUEVA FUNCIÓN PARA OBTENER PROFESORES
    public function obtenerProfesores()
    {
        $profesores = User::where('rol', 'profesor')->get(['id', 'name']);
        return response()->json($profesores);
    }
}
