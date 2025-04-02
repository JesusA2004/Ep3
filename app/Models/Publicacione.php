<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Publicacione extends Model
{
    protected $collection = 'publicaciones';
    protected $connection = 'mongodb'; // Opcional si es tu conexión por defecto

    // Campos fillable (masivamente asignables)
    protected $fillable = [
        'titulo',
        'contenido',
        'autor',     // Objeto embebido
        'comentarios' // Array de objetos
    ];

    // Casts para manejar estructuras embebidas
    protected $casts = [
        'autor' => 'array',
        'comentarios' => 'array'
    ];
}