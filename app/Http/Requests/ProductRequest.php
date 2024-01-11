<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'vendor_code'=>['required'],
            'price'=>['required', 'decimal:2'],
            'count'=>['required', 'numeric'],
            'brand_id'=>['required'],
            'model_id'=>['required'],
            'category_id'=>['required'],
            'subcategories'=>['required'],
        ];
    }

    public function messages()
    {
        return [
            'required'=>'Поле :attribute обязательно к заполнению',
            'numeric'=>'Необходимо ввести целое число',
            'decimal'=>'Необходимо ввести вещественное число с двумя позициями после точки',
        ];
    }

    public function attributes()
    {
        return [
            'vendor_code'=>'Название товара',
            'price'=>'Цена товара',
            'stock'=>'Количество товара',
            'brand_id'=>'Брэнд',
            'model_id'=>'Модель',
            'subcategories'=>'Подкатегории',
        ];
    }
}
