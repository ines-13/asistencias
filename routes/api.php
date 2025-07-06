<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\SolicitudClaseController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('membresias')->group(function () {
    Route::get('/Todas', [MembresiaController::class, 'index']);
    Route::get('/only/{id}', [MembresiaController::class, 'show']);
    Route::post('/nueva', [MembresiaController::class, 'store']);
    Route::put('/actualizarMebre/{id}', [MembresiaController::class, 'update']);
    Route::delete('/eliminarMebre/{id}', [MembresiaController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('usuarios')->group(function () {
    Route::get('/Todos', [UserController::class, 'index']);
    Route::post('/usuario', [UserController::class, 'store']);
    Route::get('/usuarios/{id}', [UserController::class, 'show']);
    Route::put('/actualizar/{id}', [UserController::class, 'update']);
    Route::delete('/eliminar/{id}', [UserController::class, 'destroy']);
});

Route::get('/usuarios/profesores', [UserController::class, 'obtenerProfesores']);

Route::get('/clima/{ciudad}', [ClimaController::class, 'obtenerClima']);

Route::prefix('clases')->group(function () {
    Route::get('/Todas', [ClaseController::class, 'index']);
    Route::post('/nueva', [ClaseController::class, 'store']);
    Route::get('/ver/{id}', [ClaseController::class, 'show']);
    Route::put('/actualizar/{id}', [ClaseController::class, 'update']);
    Route::delete('/eliminar/{id}', [ClaseController::class, 'destroy']);
    Route::get('/aceptadas/{cliente_id}', [ClaseController::class, 'aceptadasPorCliente']);
    Route::get('/por-instructor/{nombreInstructor}', [ClaseController::class, 'getClasesByInstructor']);
});

Route::middleware('auth:sanctum')->prefix('soli')->group(function () {
Route::post('/solicitudes', [SolicitudClaseController::class, 'store']);//para que un cliente envíe una solicitud para asistir a una clase.
Route::get('/solicitudes/instructor/{instructor}', [SolicitudClaseController::class, 'porInstructor']);//para que el profesor vea las solicitudes pendientes de sus clases.
Route::put('/solicitudes/{id}', [SolicitudClaseController::class, 'actualizarEstado']);// para que el profesor acepte o rechace una solicitud
Route::get('/cliente/{id}/mensajes-rechazo', [SolicitudClaseController::class, 'mensajesRechazo']);
Route::post('/mensaje-rechazo/{id}/marcar-leido', [SolicitudClaseController::class, 'marcarLeido']);
});