<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'operation_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'situation_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'prixtotaol' => 'required|numeric'

        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'Titre est obligatoire',
            'title.string' => 'Titre est incorrect',


            'description.required' => 'Description est obligatoire',
            'description.string' => 'Description est incorrect',


            'operation_id.required' => "L\'operation est obligatoire",
            'operation_id.numeric' => "L\'operation est incorrect",

            'category_id.required' => 'Category est obligatoire',
            'category_id.numeric' => 'Category est incorrect',

            'situation_id.required' => 'Situation est obligatoire',
            'situation_id.numeric' => 'Situation est incorrect',


            'city_id.required' => 'Ville est obligatoire',
            'city_id.numeric' => 'Ville est incorrect',

            'area_id.required' => 'Région est obligatoire',
            'area_id.numeric' => 'Région est incorrect',

            'prixtotaol.required' => 'Prix est obligatoire',
            'prixtotaol.numeric' => 'Prix est incorrect',

        ];
    }
}
