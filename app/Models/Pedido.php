<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Pedido extends Model
{
    protected $collection = 'pedidos';

    protected $fillable = [
        'cliente',    // Objeto embebido
        'productos',  // Array de objetos
        'fecha_entrega'
    ];

    protected $casts = [
        'cliente' => 'array',
        'productos' => 'array'
    ];
    
}