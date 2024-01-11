<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'=>'required',
            'brand_id'=>'required'
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
            'name'=>'Название модели',
            'brand_id'=>'Брэнд'
        ];
    }
}
