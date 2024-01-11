<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'=>'required',
            'country_id'=>'required'
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
            'name'=>'Название брэнда',
            'country_id'=>'Страна'
        ];
    }
}
