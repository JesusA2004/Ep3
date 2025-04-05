<?php

namespace App\Http\Controllers\Api;

use App\Models\Publicacione;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PublicacioneRequest;
use App\Http\Resources\PublicacioneResource;
use App\Http\Controllers\Controller;

class PublicacioneController extends Controller
{
    /**
     * Listado de publicaciones sin paginación (array plano)
     */
    public function index(Request $request): JsonResponse
    {
        // Obtener todas las publicaciones sin paginar
        $publicaciones = Publicacione::all();

        // Retornar la colección en un formato JSON plano
        return response()->json(PublicacioneResource::collection($publicaciones));
    }

    /**
     * Crear nueva publicación
     */
    public function store(PublicacioneRequest $request): JsonResponse
    {
        try {
            $publicacion = Publicacione::create($request->validated());
            return response()->json(new PublicacioneResource($publicacion), 201);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al crear la publicación');
        }
    }

    /**
     * Mostrar una publicación específica
     */
    public function show(Publicacione $publicacion): JsonResponse
    {
        return response()->json(new PublicacioneResource($publicacion));
    }

    /**
     * Actualizar publicación
     */
    public function update(PublicacioneRequest $request, $id): JsonResponse
    {
        try {
            // Buscar la publicación por ID
            $publicacion = Publicacione::find($id);

            // Verificar si existe
            if (!$publicacion) {
                return response()->json([
                    'message' => 'Publicación no encontrada'
                ], 404);
            }

            // Actualizar la publicación
            $publicacion->update($request->validated());

            // Recargar la publicación desde MongoDB
            $publicacion = Publicacione::find($id);

            return response()->json([
                'message' => 'Publicación actualizada correctamente',
                'data' => new PublicacioneResource($publicacion)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la publicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar publicación
     */
    public function destroy($id): JsonResponse
    {
        try {
            $publicacion = Publicacione::find($id);
            
            if (!$publicacion) {
                return response()->json([
                    'message' => 'Publicación no encontrada'
                ], 404);
            }

            $publicacion->delete();

            return response()->json([
                'message' => 'Publicación eliminada correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la publicación',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Manejo de errores
     */
    private function handleError(\Exception $e, string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error'   => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}
