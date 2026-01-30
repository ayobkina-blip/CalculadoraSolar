<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para la Identidad del Usuario.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                // Validación de unicidad adaptada a la tabla 'usuarios' y PK 'id_usuario'
                Rule::unique('usuarios', 'email')->ignore($this->user()->id_usuario, 'id_usuario'),
            ],
        ];
    }

    /**
     * Atributos personalizados para los errores.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nombre de Usuario',
            'email' => 'Dirección de Correo',
        ];
    }

    /**
     * Mensajes de error personalizados para la estética SolarCalc.
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'Este correo ya está vinculado a otra unidad del sistema.',
            'email.email' => 'El formato de comunicación ingresado no es válido.',
            'required' => 'El campo :attribute es crítico para la sincronización.',
        ];
    }
}