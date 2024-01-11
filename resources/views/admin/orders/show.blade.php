@extends('templates.admin')
@section('content')
    <h2>Заказ пользователя {{$orders[0]->order->user->email}}</h2>
    <div class="scroll-table">
        <table>
            <thead>
                <tr>
                    <th>Заказаные продукты</th>
                    <th>Количество</th>
                    <th>Цена</th>
                </tr>
            </thead>
        </table>
        <div class="scroll-table-body">
            <table>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{$order->product->full_name}}</td>
                        <td>{{$order->amount}}</td>
                        <td>{{$order->product->price}} руб.</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <span>Итого: {{$orders[0]->order->sum}}</span>
    </div>
@endsection
