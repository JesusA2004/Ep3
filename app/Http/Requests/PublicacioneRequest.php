<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicacioneRequest extends FormRequest
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
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'autor.nombre' => 'required|string|max:100',
            'autor.email' => 'required|email',
            'autor.rol' => 'nullable|string|max:50',
            'comentarios' => 'sometimes|array',
            'comentarios.*.nombre_usuario' => 'required|string|max:100',
            'comentarios.*.texto' => 'required|string|max:500',
            'comentarios.*.fecha' => 'sometimes|date'
        ];
    }
}
