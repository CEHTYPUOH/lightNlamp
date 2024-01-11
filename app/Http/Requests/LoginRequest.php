<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'=>['required', 'email'],
            'password'=>['required'],
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Поле :attribute обязательно для заполнения',
            'email'=>'Адрес электронной почты введён некорректно',
        ];
    }

    public function attributes()
    {
        return [
            'password'=>'Пароль',
        ];
    }
}
