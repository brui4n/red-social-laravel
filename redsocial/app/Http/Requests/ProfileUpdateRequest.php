<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'nombre' => ['required', 'string', 'max:255'],
            
            'username' => [
                'required', 
                'string', 
                'max:255', 
                'alpha_dash', // Solo letras, números, guiones y guiones bajos
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            
            'bio' => ['nullable', 'string', 'max:500'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            
            'avatar' => [
                'nullable', 
                'image', 
                'mimes:jpeg,png,jpg,gif,webp', 
                'max:2048' // 2MB máximo
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'username.alpha_dash' => 'El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.',
            'username.max' => 'El nombre de usuario no puede tener más de 255 caracteres.',
            
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            
            'bio.max' => 'La biografía no puede tener más de 500 caracteres.',
            
            'ubicacion.max' => 'La ubicación no puede tener más de 255 caracteres.',
            
            'sitio_web.url' => 'Debe ser una URL válida (ejemplo: https://ejemplo.com).',
            'sitio_web.max' => 'La URL no puede tener más de 255 caracteres.',
            
            'avatar.image' => 'El archivo debe ser una imagen.',
            'avatar.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif o webp.',
            'avatar.max' => 'La imagen no puede ser mayor a 2MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre',
            'username' => 'nombre de usuario',
            'email' => 'correo electrónico',
            'bio' => 'biografía',
            'ubicacion' => 'ubicación',
            'sitio_web' => 'sitio web',
            'avatar' => 'foto de perfil',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpiar el sitio web si se proporciona
        if ($this->sitio_web && !str_starts_with($this->sitio_web, 'http')) {
            $this->merge([
                'sitio_web' => 'https://' . $this->sitio_web
            ]);
        }

        // Limpiar el username (convertir a minúsculas y quitar espacios)
        if ($this->username) {
            $this->merge([
                'username' => strtolower(trim($this->username))
            ]);
        }
    }
}