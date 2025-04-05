<?php

namespace App\Http\Controllers\Api;

use App\Models\Evento;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\EventoRequest;
use App\Http\Resources\EventoResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class EventoController extends Controller
{
    /**
     * Listado de eventos sin paginación
     */
    public function index(Request $request): JsonResponse
    {
        // Se obtienen todos los eventos
        $eventos = Evento::all();

        // Retornar la colección en un formato JSON plano
        return response()->json(EventoResource::collection($eventos));
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
            return response()->json([
                'message' => 'Evento eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
