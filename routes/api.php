<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PublicacioneController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas por JWT
Route::middleware(['jwt.auth'])->group(function () {

    Route::get('/user', function (Request $request) {
        return response()->json(auth()->user());
    });

    Route::apiResource('publicaciones', PublicacioneController::class);
    Route::apiResource('eventos', EventoController::class);
});
