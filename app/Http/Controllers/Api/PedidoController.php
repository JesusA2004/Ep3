<?php

namespace App\Http\Controllers\Api;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\PedidoRequest;
use App\Http\Resources\PedidoResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $pedidos = Pedido::filter($request->query())
            ->paginate($request->input('per_page', 20));

        return PedidoResource::collection($pedidos)->response();
    }

    public function store(PedidoRequest $request): JsonResponse
    {
        try {
            $pedido = Pedido::create($request->validated());
            return response()->json(
                new PedidoResource($pedido), 
                201
            );
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al crear el pedido');
        }
    }

    public function show(Pedido $pedido): JsonResponse
    {
        return response()->json(new PedidoResource($pedido));
    }

    public function update(PedidoRequest $request, Pedido $pedido): JsonResponse
    {
        try {
            $pedido->update($request->validated());
            return response()->json(
                new PedidoResource($pedido->refresh())
            );
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al actualizar el pedido');
        }
    }

    public function destroy(Pedido $pedido): JsonResponse
    {
        try {
            $pedido->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Error al eliminar el pedido');
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