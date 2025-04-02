<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('publicaciones', PublicacioneController::class);

Route::apiResource('pedidos', PedidoController::class);

Route::apiResource('eventos', EventoController::class);
