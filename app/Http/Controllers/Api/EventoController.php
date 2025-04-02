<?php

namespace App\Http\Controllers\Api;

use App\Models\Evento;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\EventoRequest;
use App\Http\Resources\EventoResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class EventoController extends Controller
{
    /**
     * Listado de eventos con paginación
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 20); // Usar mismo valor que $perPage del modelo
        $eventos = Evento::paginate($perPage);

        return EventoResource::collection($eventos)->response();
    }

    /**
     * Crear nuevo evento
     */
    public function store(EventoRequest $request): JsonResponse
    {
        try {
            $evento = Evento::create($request->validated());
            return response()->json(
                new EventoResource($evento),
                201 // Código HTTP 201 para creación
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un evento específico
     */
    public function show(Evento $evento): JsonResponse
    {
        return response()->json(
            new EventoResource($evento)
        );
    }

    /**
     * Actualizar evento
     */
    public function update(EventoRequest $request, Evento $evento): JsonResponse
    {
        try {
            $evento->update($request->validated());
            return response()->json(
                new EventoResource($evento->refresh())
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar evento
     */
    public function destroy(Evento $evento): JsonResponse
    {
        try {
            $evento->delete();
            return response()->json(null, 204); // 204 No Content
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}