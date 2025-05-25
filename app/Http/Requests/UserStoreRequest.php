<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'store_name' => 'nullable|string',
            // 'user_id' => 'required|string|unique:stores,store_name',


            'store_email' => 'nullable|email',

            'fb_link' => 'nullable|string',

            'site_link' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'logo.image' => 'Le logo doit être un fichier image valide.',
            'logo.mimes' => 'Le logo doit être un fichier JPEG, PNG, JPG ou GIF.',
            'logo.max' => 'Le logo doit avoir une taille inférieure à 2 Mo.',

            'banner.image' => 'La bannière doit être un fichier image valide.',
            'banner.mimes' => 'La bannière doit être un fichier JPEG, PNG, JPG ou GIF.',
            'banner.max' => 'La bannière doit avoir une taille inférieure à 2 Mo.',


            'store_name	.unique' => 'Le nom de la boutique doit être unique.',
            'store_name	.string' => 'Le nom de la boutique doit être une chaîne de caractères.',


            'store_email.email' => 'L\'adresse e-mail de la boutique doit être une adresse e-mail valide.',

            'fb_link.string' => 'Le lien Facebook doit être une chaîne de caractères.',

            'site_link.string' => 'Le lien du site doit être une chaîne de caractères.',


        ];
    }
}
