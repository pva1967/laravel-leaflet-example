<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
           $rules  = [
            'name'  => 'required|max:60',
            'email' => 'email:rfc,dns',
            'phone' => 'numeric',
            'language' => 'required',
            'type' => 'required',
            //
        ];
        if ($this->input('rules_type') == 'create')
            $rules['name'] =$rules['name'].'|unique:contacts';
        return $rules;
    }

    public function messages()
    {
        return [
            'unique'  => 'Поле должно быть уникальным, выберите другое значение',
            'email' => 'Неверный формат',
            'rfc' => 'RFC',
            'dns' => 'DNS',
            'numeric' => 'Только цифры',

            //
        ];
    }
}
