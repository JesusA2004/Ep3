<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente.nombre' => 'required|string|max:150',
            'cliente.direccion.calle' => 'required|string|max:200',
            'cliente.direccion.codigo_postal' => 'required|string|size:5',
            'cliente.direccion.ciudad' => 'required|string|max:100',
            'productos' => 'required|array|min:1',
            'productos.*.nombre' => 'required|string|max:100',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.cantidad' => 'required|integer|min:1',
            'fecha_entrega' => 'required|date|after:today'
        ];
    }
}
