<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassifiedRequest extends FormRequest
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
            'categorie_id' => 'required|exists:classified_categories,id',
            'price' => 'required|numeric|min:0',
            'type_annonceur' => 'required|in:0,1',
            'type_product' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'condition_product' => 'required',
            
        ];
    }



    public function messages(): array
    {
        return [
            'title.required' => 'Titre est obligatoire',
            'title.string' => 'Titre est incorrect',


            'description.required' => 'Description est obligatoire',
            'description.string' => 'Description est incorrect',


            

            'category_id.required' => 'Category est obligatoire',
            'category_id.numeric' => 'Category est incorrect',

            


            'city_id.required' => 'Ville est obligatoire',
            'city_id.numeric' => 'Ville est incorrect',

            'area_id.required' => 'Région est obligatoire',
            'area_id.numeric' => 'Région est incorrect',

            'prixtotaol.required' => 'Prix est obligatoire',
            'prixtotaol.numeric' => 'Prix est incorrect',

        ];
    }
}
