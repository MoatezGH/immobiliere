<?php

namespace App\Http\Requests;

use App\Rules\UniqueEmail;
use Illuminate\Foundation\Http\FormRequest;

class RequestImmoRegister extends FormRequest
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

        $types = ['entreprise', 'particulier', 'promoteur'];
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', new UniqueEmail],
            'password' => 'required|string|min:8|confirmed',
            // 'category' => 'required|string',
            'category' => 'required|string|in:' . implode(',', $types),

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nom & prénom est obligatoire',
            'name.string' => 'Nom & prénom est incorrect',


            'email.required' => 'E-mail est obligatoire',
            'email.email' => 'E-mail est incorrect',
            'email.unique' => 'E-mail est déja exist',

            'password.required' => 'Mot de passe est obligatoire',
            'password.string' => 'Mot de passe est incorrect',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères ',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',


            'category.required' => 'Category est obligatoire',
            'category.string' => 'Category est incorrect',
            'category.in' => 'La catégorie sélectionnée est invalide',

        ];
    }
}
