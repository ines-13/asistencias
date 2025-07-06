<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $fillable = [
        'nombre',
        'nivel',
        'dia',
        'hora',
        'instructor',
    ];
}
