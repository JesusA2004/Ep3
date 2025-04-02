<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Evento extends Model
{
    protected $collection = 'eventos';

    protected $fillable = [
        'nombre',
        'ubicacion',  // Objeto embebido
        'asistentes'  // Array de objetos
    ];

    protected $casts = [
        'ubicacion' => 'array',
        'asistentes' => 'array'
    ];

}
