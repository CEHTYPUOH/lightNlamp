<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacteristicRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Поле :attribute обязательно к заполнению',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'Название характеристики',
        ];
    }
}
