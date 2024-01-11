<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'=>'required',
            'category_id'=>'required'
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
            'category_id'=>'Категория'
        ];
    }
}
