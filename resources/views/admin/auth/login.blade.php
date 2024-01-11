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
<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
<form method="POST" action="{{ route('admin.auth') }}">
    @csrf
    <h2 class="mb-3">Вход в панель администрирования</h2>
    <div class="form-outline mb-3">
    <label for="email-login">Email</label>
      <input type="email" id="email-login" value="{{ old('login') }}" name="email" class="form-control" placeholder="Email"/>
    </div>
    <div class="form-outline mb-3">
        <label for="password-login">Пароль</label>
      <input type="password" id="password-login" class="form-control" name="password" placeholder="Пароль"/>
    </div>
    <div class="d-flex justify-content-center">
    <button type="submit" id="authBtn" class="btn btn-primary btn-block mb-3">Войти</button>
    </div>
  </form>
</div>
</body>
</html>
