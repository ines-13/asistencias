<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;

    protected $table = 'membresias';
    protected $primaryKey = 'id_membresia';
    public $timestamps = false;

    protected $fillable = [
        'tipo_membresia',
        'fecha_inicio',
        'fecha_fin',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
public function usuarios()
{
    return $this->hasMany(User::class, 'membresia_id', 'id_membresia');
}

}

