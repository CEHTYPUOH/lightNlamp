@extends('templates.app')
@section('content')
<div class="d-flex justify-content-center" style="height: 100vh; margin-top: 100px;">
<form method="POST" action="{{route('users.store')}}">
    @csrf
        <h2 class="mb-3">Регистрация</h2>
    <div hidden>
        <input type="text" name="role_id" id="role_id" value="1">
    </div>

  <div class="form-outline mb-3">
    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
        name="name" value="{{ old('name') }}" placeholder="Имя"/>
    @error('name')
        <span class="text-danger">{{ $message }}</span>
    @enderror
  </div>

  <div class="form-outline mb-3">
    <input type="text" id="surname" class="form-control @error('surname') is-invalid @enderror"
        name="surname" value="{{ old('surname') }}" placeholder="Фамилия"/>
    @error('surname')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

  <div class="form-outline mb-3">
    <input type="text" id="patronymic" class="form-control @error('patronymic') is-invalid @enderror"
        name="patronymic" value="{{ old('patronymic') }}" placeholder="Отчество"/>
    @error('patronymic')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

  <div class="form-outline mb-3">
    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
        name="email" value="{{ old('email') }}" placeholder="Email"/>
    @error('email')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

  <div class="form-outline mb-3">
    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
    placeholder="Пароль"/>
    @error('password')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

  <div class="form-outline mb-3">
    <input type="password" id="password_confirmation" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"
    placeholder="Подтверждение пароля"/>
</div>

    <div class="d-flex justify-content-center">
    <button type="submit" class="btn btn-primary btn-block mb-3">Зарегистрироваться</button>
    </div>
    <div class="text-center">
      <p>Уже зарегистрированы? <a href="{{route('users.auth')}}">Авторизация</a></p>
    </div>
  </form>
  @endsection
</div>
