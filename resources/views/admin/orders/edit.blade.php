@extends('templates.admin')
@section('content')
<form method="POST" action="{{route('admin.orders.update', $order->id)}}" class="w-50 mx-auto m-5" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="mb-3">
        <label for="status_id" class="form-label">Статус</label>
        <select name="status_id" id="status_id" class="form-control">
            @foreach ($statuses as $status)
                <option value="{{$status->id}}">{{$status->name}}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
</form>
@endsection
