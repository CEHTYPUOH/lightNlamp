<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Light and Lamp</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        {{-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> --}}
        <ul class="navbar-nav px-3">
          <li class="nav-item text-nowrap">
            <a class="nav-link" href="{{route('admin.logout')}}">Выйти</a>
          </li>
        </ul>
      </header>

      <div class="container-fluid">
        <div class="row">
          <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
              <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.orders')}}">
                      <span data-feather="shopping-cart"></span>
                      Заказы
                    </a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.products')}}">
                    <span data-feather="shopping-cart"></span>
                    Товары
                  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.categories')}}">
                      <span data-feather="shopping-cart"></span>
                      Категории
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.subcategories')}}">
                      <span data-feather="shopping-cart"></span>
                      Подкатегории
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.brands')}}">
                      <span data-feather="shopping-cart"></span>
                      Брэнды
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.models')}}">
                      <span data-feather="shopping-cart"></span>
                      Модели
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.characteristics')}}">
                      <span data-feather="shopping-cart"></span>
                      Характеристики
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.countries')}}">
                      <span data-feather="shopping-cart"></span>
                      Страны
                    </a>
                </li>
              </ul>
            </div>
          </nav>

          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container p-3">
                @yield('content')
            </div>
          </main>
        </div>
      </div>

      @stack('script')
</body>
</html>
