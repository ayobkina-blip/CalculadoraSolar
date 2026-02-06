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
     * Reglas de validación flexibles para la Identidad del Usuario.
     * Permite actualizar solo nombre, solo email, solo avatar, o cualquier combinación.
     */
    public function rules(): array
    {
        $user = $this->user();
        
        return [
            // Nombre: opcional pero si se envía debe cumplir las reglas
            'name' => [
                'sometimes', // Solo valida si el campo está presente
                'nullable',  // Puede ser null
                'string',
                'min:2',
                'max:100',
                'regex:/^[\p{L}\s\-\'\.]+$/u', // Solo letras, espacios, guiones, apostrofes y puntos
            ],
            // Email: opcional pero si se envía debe cumplir las reglas
            'email' => [
                'sometimes', // Solo valida si el campo está presente
                'nullable',  // Puede ser null
                'string',
                'lowercase',
                'email:rfc', // Validación RFC (sin DNS para evitar problemas)
                'max:255',
                // Validación de unicidad adaptada a la tabla 'usuarios' y PK 'id_usuario'
                Rule::unique('usuarios', 'email')->ignore($user->id_usuario, 'id_usuario'),
            ],
            // Avatar: completamente opcional
            'avatar' => [
                'nullable',
                'sometimes',
                'image',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:2048', // Máximo 2MB
                'dimensions:max_width=2000,max_height=2000', // Dimensiones máximas
            ],
        ];
    }

    /**
     * Atributos personalizados para los errores (nombres más amigables).
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'avatar' => 'imagen de perfil',
        ];
    }

    /**
     * Mensajes de error personalizados y claros en español.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 2 caracteres.',
            'name.max' => 'El nombre no puede exceder los 100 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras, espacios, guiones y apostrofes.',
            
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, introduce una dirección de correo electrónico válida.',
            'email.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            'email.max' => 'El correo electrónico no puede exceder los 255 caracteres.',
            
            'avatar.image' => 'El archivo debe ser una imagen válida.',
            'avatar.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, gif o webp.',
            'avatar.max' => 'La imagen no puede pesar más de 2MB.',
            'avatar.dimensions' => 'La imagen no puede exceder 2000x2000 píxeles.',
            
            'required' => 'El campo :attribute es obligatorio.',
        ];
    }
}