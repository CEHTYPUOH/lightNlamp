@extends('templates.admin')
@section('content')
    <form method="POST" action="{{route('admin.models.update', $model->id)}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="name" class="form-label">Название модели</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$model->name}}">
            @error('msg')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">Брэнд</label>
            <select name="brand_id" id="brand_id" class="form-control">
                @foreach ($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
@endsection
