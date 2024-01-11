<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCharacteristicRequest extends FormRequest
{
    public function rules()
    {
        return [
            'value'=>['required'],
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
            'value'=>'Значение',
        ];
    }
}
