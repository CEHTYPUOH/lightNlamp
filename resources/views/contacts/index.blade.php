@extends('templates.app')
@section('content')
    <h1>Свяжитесь с нами</h1>
    <p>Заполните форму ниже, чтобы связаться с нами.</p>
    <form class="" style="height: 50vh">
        <div class="form-group mb-3">
            <label for="message">Сообщение</label>
            <textarea class="form-control" id="message" rows="6"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
@endsection
