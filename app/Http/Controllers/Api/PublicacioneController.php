<?php

namespace App\Http\Controllers\Api;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PublicacionRequest;
use App\Http\Resources\PublicacionResource;
use Illuminate\Http\JsonResponse;

class PublicacionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 20);
        $publicaciones = Publicacion::paginate($perPage);

        return PublicacionResource::collection($publicaciones)->response();
    }

    public function store(PublicacionRequest $request): JsonResponse
    {
        try {
            $publicacion = Publicacion::create($request->validated());
            return response()->json(
                new PublicacionResource($publicacion), 
                201
            );
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al crear la publicación');
        }
    }

    public function show(Publicacion $publicacion): JsonResponse
    {
        return response()->json(new PublicacionResource($publicacion));
    }

    public function update(PublicacionRequest $request, Publicacion $publicacion): JsonResponse
    {
        try {
            $publicacion->update($request->validated());
            return response()->json(
                new PublicacionResource($publicacion->refresh())
            );
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al actualizar la publicación');
        }
    }

    public function destroy(Publicacion $publicacion): JsonResponse
    {
        try {
            $publicacion->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al eliminar la publicación');
        }
    }

    private function handleError(\Exception $e, string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
    
}