<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudClase extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_clase';

    protected $fillable = [
        'clase_id',
        'cliente_id',
        'estado',
        'mensaje_cliente',
        'leido_cliente',
    ];

    protected $casts = [
        'leido_cliente' => 'boolean',
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
