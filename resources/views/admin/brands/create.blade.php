@extends('templates.admin')
@section('content')
    <form method="POST" action="{{route('admin.brands.store')}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название брэнда</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
            @error('name')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="country_id" class="form-label">Страна</label>
            <select name="country_id" id="country_id" class="form-control">
                @foreach ($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
            @error('country_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection
