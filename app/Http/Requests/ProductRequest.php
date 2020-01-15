<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'category_id'=>'required',
            'description'=>'required',
            'images.*'=>'image'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Este campo é obrigatório!',
            'min'=>'Este campo precisa ter no mínimo :min caracteres',
            'image'=>'O arquivo precisa ser uma imagem'
        ];
    }
}
