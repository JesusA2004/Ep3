<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Validación para el campo principal
            'nombre' => 'required|string|max:255',
            
            // Validación para el objeto embebido 'ubicacion'
            'ubicacion.direccion' => 'required|string|max:200',
            'ubicacion.codigo_postal' => 'required|string|size:5',
            
            // Validación para el array de objetos 'asistentes'
            'asistentes' => 'sometimes|array',
            'asistentes.*.nombre' => 'required|string|max:100',
            'asistentes.*.empresa' => 'nullable|string|max:100'
        ];
    }

    public function messages()
    {
        return [
            'ubicacion.direccion.required' => 'La dirección es obligatoria',
            'asistentes.*.nombre.required' => 'Cada asistente debe tener un nombre'
        ];
    }
    
}
