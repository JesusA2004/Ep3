<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function __construct()
    {
        // Middleware guest para evitar que usuarios autenticados accedan a este endpoint
        $this->middleware('guest');
    }

    /**
     * Registra un nuevo usuario y devuelve un token de autenticación JWT.
     */
    public function register(Request $request)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear el nuevo usuario
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generar token JWT desde el usuario
        $token = JWTAuth::fromUser($user);

        // Retornar el token y la info del usuario
        return response()->json([
            'token' => $token,
            'user'  => $user,
        ], 201);
    }
}
