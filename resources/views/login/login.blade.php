@extends('templates.app')
@section('content')
<div class="d-flex justify-content-center" style="height: 100vh; margin-top: 150px;">
<form method="POST" action="{{ route('users.login') }}">
    @csrf
        <h2 class="mb-3">Авторизация</h2>
    <div class="form-outline mb-3">
      <input type="email" id="email" name="email" value="{{ old('login') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email"/>
      @error('email')
        <span class="text-danger">{{$message}}</span>
      @enderror
    </div>

    <div class="form-outline mb-3">
      <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль"/>
      @error('password')
        <span class="text-danger">{{$message}}</span>
      @enderror
    </div>
    @error('invalidData')
        <span class="text-danger">{{$message}}</span>
    @enderror
    <div class="d-flex justify-content-center">
    <button type="submit" id="authBtn" class="btn btn-primary btn-block mb-3">Авторизоваться</button>
    </div>
    <div class="text-center">
      <p>Ещё не зарегистрированы? <a href="{{route('users.create')}}">Регистрация</a></p>
    </div>
  </form>
@endsection
</div>
