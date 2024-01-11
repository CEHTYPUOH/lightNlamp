@extends('templates.admin')
@section('content')
    <form method="POST" action="{{route('admin.countries.store')}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название страны</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
            @if($errors->any())
                <span class="text-danger">{{$errors->first()}}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection
