<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreUsuariosRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'dni' => 'required|numeric|min:8',
            'password_confirmation' => 'confirmed:password'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
            $rules['email'] = 'required|email|unique:users,email,' . $this->usuario->id;
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'password_confirmation' => 'La contraseña de confirmación no coincide.',
        ];
    }
}
