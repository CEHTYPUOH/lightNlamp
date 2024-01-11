@extends('templates.admin')
@section("content")
    <h2>{{$product->getProductName($product->id)}}</h2>
    <img src="{{$product->image}}" class="w-25" alt="">
    <div class="card-body p-3">
        <p class="card-text">
        <span>Цена: {{$product->price}}₽</span><br>
        <span>Количество: {{$product->count}}</span><br>
        <span>Страна: {{$product->getProductCountry($product->id)}}</span><br>
        <span>Категория: {{$product->getProductCategory($product->id)}}</span><br>
        <span>Подкатегории:<br>
            @foreach ($product->getProductSubcategories($product->id) as $subcategory)
                <span>{{$subcategory[0]->name}}</span><br>
            @endforeach
        </span>
        <span>Изображения:</span>
        <div>
        @foreach ($product->getProductImages($product->id) as $image)
            <img src="{{$image[0]->url}}" alt="" class="w-25">
        @endforeach
        </div>
        <span>Характеристики:</span>
        <div>
        @foreach ($product->getProductCharacteristics($product->id) as $characteristic)
            <span>{{$characteristic->name}}: {{$product->getProductCharacteristicValue($product->id, $characteristic->id)}}</span>
        @endforeach
        </div>
        </p>
    </div>
@endsection
