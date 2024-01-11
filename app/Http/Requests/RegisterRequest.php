<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>['required', 'regex:/^[а-яё\s\-]+$/iu'],
            'surname'=>['required', 'regex:/^[а-яё\s\-]+$/iu'],
            'patronymic'=>['regex:/^[а-яё\s\-]+$/iu'],
            'email'=>['required', 'email', 'unique:users'],
            'password'=>['required', 'regex:/^[a-z\d\-]{6,}/i','confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Поле :attribute обязательно для заполнения',
            'unique'=>'Поле :attribute должно быть уникальным',
            'regex'=>'Поле :attribute не соотеветствует шаблону',
            'email'=>'Адрес электронной почты введён некорректно',
            'confirmed'=>'Пароли не совпадают',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'Имя',
            'surname'=>'Фамилия',
            'patronymic'=>'Отчество',
            'password'=>'Пароль',
        ];
    }
}
