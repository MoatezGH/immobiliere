<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class updateProfileRequest extends FormRequest
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
    public function rules(User $user): array
    {
        $user = Auth::user();
        return [
            'username' => 'nullable|string|max:255',
            // 'email' =>
            // 'nullable|email|unique:users,email->ignore(' . $user->id . ')',
            'phone' => 'nullable|numeric',
            'mobile' => 'nullable|numeric',
            'city_id' => 'nullable|numeric',
            'area_id' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'username.string' => 'Nom & prénom est incorrect',
            'username.max' => 'Nom & prénom est trop long',

            // 'email.required' => 'E-mail est obligatoire',
            // 'email.email' => 'E-mail est incorrect',
            // 'email.unique' => 'E-mail est déja exist',

            'phone.numeric' => 'Téléphone fixe est incorrect',
            'phone.max' => 'Téléphone fixe est trop long',

            'mobile.numeric' => 'Téléphone mobile est incorrect',
            'mobile.max' => 'Téléphone mobile est trop long',

            'city_id.numeric' => 'Ville est incorrect',
            'city_id.max' => 'Ville est trop long',

            'area_id.numeric' => 'Région est incorrect',
            'area_id.max' => 'Région est trop long',

            'address.string' => 'Adresse est incorrect',
            'address.max' => 'Adresse est trop long',

        ];
    }
}
