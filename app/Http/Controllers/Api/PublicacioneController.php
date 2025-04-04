<?php

namespace App\Http\Controllers\Api;

use App\Models\Publicacione;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PublicacioneRequest;
use App\Http\Resources\PublicacioneResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PublicacioneController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 20);
        $publicaciones = Publicacione::paginate($perPage);

        return PublicacioneResource::collection($publicaciones)->response();
    }

    public function store(PublicacioneRequest $request): JsonResponse
    {
        try {
            $publicacion = Publicacione::create($request->validated());
            return response()->json(
                new PublicacioneResource($publicacion), 
                201
            );
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al crear la publicación');
        }
    }

    public function show(Publicacione $publicacion): JsonResponse
    {
        return response()->json(new PublicacioneResource($publicacion));
    }

    public function update(PublicacioneRequest $request, Publicacione $publicacion): JsonResponse
    {
        try {
            $publicacion->update($request->validated());
            return response()->json(
                new PublicacioneResource($publicacion->refresh())
            );
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al actualizar la publicación');
        }
    }

    public function destroy(Publicacione $publicacion): JsonResponse
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