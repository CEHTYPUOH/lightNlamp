@extends('templates.app')
@section('content')
        <form action="{{route('products')}}" method="GET" class="pt-3">
            @csrf
        <div class="d-flex align-items-center">
        <button id="filter-btn" type="button" class="d-flex border-0 text-white justify-content-center align-items-center" id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill"
            viewBox="0 0 16 16">
                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"/>
            </svg>
            <span>Фильтры</span>
            </div>
        </button>
        <div class="dropdown">
            <div class="dropdown-menu" aria-labelledby="dropdownMenu">
            <button type="submit" name="category_id" value="0" class="dropdown-item">Все</button>
            @foreach ($categories as $category)
            <div class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">{{$category->name}}</a>
                <div class="dropdown-menu">
                    <button type="submit" name="subcategory_id" value="{{$category->subcategories}}" class="dropdown-item" href="#">Все</button>
                    @foreach ($category->subcategories as $subcategory)
                        <button type="submit" name="subcategory_id" value="{{$subcategory->id}}" class="dropdown-item" href="#">{{$subcategory->name}}</button>
                    @endforeach
                </div>
              </div>
            @endforeach
            </div>
          </div>
        <div class="ms-3">
        <span>Сортировать по</span>
        <select name="sortBy" id="sort-field" style="height: 30px; width: 75px;">
            <option @if($sort != [] && $sort[1] == "date")
                selected
            @endif value="date">дате</option>
            <option @if($sort != [] && $sort[1] == "price")
                selected
            @endif value="price">цене</option>
        </select>
        </div>
        <div class="ms-3">
            <div>
            <input type="radio" name="sort" value="decs" @if(count($sort) != 0 && $sort[0] == "decs")
                checked
            @endif id="decs_radio">
            <label for="decs_radio">По убыванию</label>
            </div>
            <div>
            <input type="radio" name="sort" @if (count($sort) == 0)
                checked
            @endif value="inc" @if(count($sort) != 0 && $sort[0] == "inc")
                checked
            @endif id="inc_radio">
            <label for="inc_radio">По возрастанию</label>
            </div>
        </div>
        <button class="btn btn-primary ms-3" style="font-weight: 500;" value="{{json_encode($products)}}" name="filter_products" type="submit">Применить</button>
        </form>
        </div>
        <div class="row row-cols-3 gx-5 gy-2 py-3 mx-auto">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100" style="width: 350px;">
                        <img src="{{ $product->images->first()?->url }}" class="card-img-top" style="height: 300px"
                             alt="...">
                        <div class="card-body d-flex flex-column">
                            <div class="h-100">
                                <h4 class="card-title">{{ $product->full_name }}</h4>
                            </div>
                            <div class="mt-auto">
                            <p class="card-text">
                                <h5>{{ $product->price }}₽</h5>
                            </p>
                            <div class="d-flex justify-content-around">
                                <a href="{{route('products.show', $product->id)}}" class="btn btn-primary">Подробнее</a>
                                @auth()
                                @if (in_array($product->id, $addedProducts))
                                    <a href="#" disabled data-id="{{ $product->id }}" class="btn btn-secondary">В
                                    корзине</a>
                                @else
                                    <a href="#" data-id="{{ $product->id }}" class="addCartBtn btn btn-primary">В
                                        корзину</a>
                                @endif
                                @endauth
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('/js/script.js')}}"></script>
    <script>
        let btns = [...document.querySelectorAll('.addCartBtn')];
        btns.forEach((btn) => {
            btn.addEventListener('click', async (e) => {
                btn.outerHTML = `
                    <a href="#" disabled data-id="{{ $product->id }}" class="btn btn-secondary">В
                        корзине</a>
                `
                e.preventDefault()
                await postJson('{{route('cart.add')}}', e.target.dataset.id, '{{csrf_token()}}')
            })
        })
    </script>

@endpush
