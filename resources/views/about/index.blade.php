@extends('templates.app')
@section('content')
    <h1 class="text-center mb-5">О нас</h1>
    <div class="row">
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <p>Мы являемся одним из крупнейших интернет-магазинов светильников и люстр в России.</p>
            <p>Наши товары отличаются высоким качеством и доступными ценами.</p>
            <p>Мы предлагаем широкий ассортимент светильников и люстр различных стилей и направлений, чтобы удовлетворить
                потребности любого покупателя.</p>
            <p>
                Адрес: г.Челябинск, ул.Гагарина 7 <br>
                Номер: +7 (909) 341-01-03
            </p>
        </div>
        <div class="col-md-6">
            <img src="{{Storage::url('/products/map.jpg')}}" class="w-100 h-100" height="100">
        </div>
    </div>
@endsection
