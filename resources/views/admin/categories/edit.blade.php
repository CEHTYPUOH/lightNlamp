@extends('templates.admin')
@section('content')
    <form method="POST" action="{{route('admin.categories.update', $category->id)}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="name" class="form-label">Название категории</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}">
            @if($errors->any())
                <span class="text-danger">{{$errors->first()}}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
@endsection
