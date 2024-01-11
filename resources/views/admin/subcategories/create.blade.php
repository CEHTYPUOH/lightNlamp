@extends('templates.admin')
@section('content')
    <form method="POST" action="{{route('admin.subcategories.store')}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название подкатегории</label>
            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
            @if($errors->any())
                <span class="text-danger">{{$errors->first()}}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Категория</label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection
