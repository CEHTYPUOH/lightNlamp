@extends('templates.app')
@section('content')
    <div class="d-flex mt-3">
        <div class="d-flex flex-column col-md-6 p-3">
        <div>
            <img src="{{ $product->getProductImage()?->url }}" style="height: 500px;" class="w-100" id="main-image" alt="Товар" class="d-block">
        </div>
            <div class="d-flex">
                @foreach ($product->images as $key=>$image)
                <div class="col-md-2">
                    <img style="height: 100px;" src="{{$image->url}}" class="w-100" alt="{{$image->url}}" onmouseover="changeImage(this.src)">
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 p-3">
            <h1 class="mb-4">{{ $product->full_name }}</h1>
            <h3>Характеристики</h3>
            <p class="lead">
                @foreach ($product->characteristics as $characteristic)
                    <span>{{ $characteristic->name }}: {{ $characteristic->pivot->value }}</span><br>
                @endforeach
            </p>
            <p>Страна-изготовитель: {{ $product->model->brand->country->name }}</p>
            <hr class="my-4">
            <h2 class="mb-4">Цена: {{ $product->price }} руб.</h2>
            @auth()
            @if (in_array($product->id, $addedProducts))
            <a href="#" disabled data-id="{{ $product->id }}" class="btn btn-secondary btn-lg">В
            корзине</a>
        @else
            <a href="#" data-id="{{ $product->id }}" class="addCartBtn btn btn-primary btn-lg">В
                корзину</a>
        @endif
            @endauth
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('/js/script.js')}}"></script>
    <script>
        [...document.querySelectorAll('.addCartBtn')].forEach((btn) => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault()
                await postJson('{{route('cart.add')}}', e.target.dataset.id, '{{csrf_token()}}')
            })
        })
    </script>
    <script>
        let btns = [...document.querySelectorAll('.addCartBtn')];
        btns.forEach((btn) => {
            btn.addEventListener('click', async (e) => {
                btn.outerHTML = `
                <a href="#" disabled data-id="{{ $product->id }}" class="btn btn-secondary btn-lg">В
            корзине</a>
                `
                e.preventDefault()
                await postJson('{{route('cart.add')}}', e.target.dataset.id, '{{csrf_token()}}')
            })
        })
    </script>
    <script>
        function changeImage(src) {
             document.getElementById("main-image").src = src;
        }
    </script>
@endpush
