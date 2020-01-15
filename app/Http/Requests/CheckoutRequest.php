<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'client_name'=>'required',
            'client_email'=>'required|email',
            'client_phone'=>'required|regex:/\+55 \(\d{2}\) \d{5}-\d{4}/',
            'endereco.cep'=>'required|formato_cep',
            'endereco.logradouro'=>'required',
            'endereco.numero'=>'required',
            'endereco.estado'=>'required',
            'endereco.cidade'=>'required',
            'carrier'=>'required',
            'gateway'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'number'=>'Este campo precisa ser um número válido',
            'email'=>'Endereço de e-mail inválido',
            'required'=>'Este campo é obrigatório'
        ];
    }
}
