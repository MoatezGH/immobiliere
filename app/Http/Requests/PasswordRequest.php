<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'password' => 'required|min:8',
        ];
    }



    public function messages(): array
    {
        return [
            'password.required' => 'Mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères ',
            // 'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
            'password.required' => 'Ancien mot de passe est obligatoire',
        ];
    }
}
