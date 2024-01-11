@extends('templates.app')
@section('content')
    <h2>Личная информация</h2>
    <form action="{{route('users.update', $user->id)}}" method="POST" class="w-25">
    @csrf
    @method('PATCH')
    <div class="d-flex flex-column">
        <div class="d-flex justify-content-between m-1" style="width: 275px">
        <span>Почта:</span>
        <input type="text" name="email" id="emailEdit" value="{{$user->email}}" disabled>
        </div>
        <div class="d-flex justify-content-between m-1" style="width: 275px">
        <span>Фамилия:</span>
        <input type="text" name="surname" id="surnameEdit" value="{{$user->surname}}" disabled>
        </div>
        <div class="d-flex justify-content-between m-1" style="width: 275px">
        <span>Имя:</span>
        <input type="text" name="name" id="nameEdit" value="{{$user->name}}" disabled>
        </div>
        <div class="d-flex justify-content-between m-1" style="width: 275px">
        <span>Отчество:</span>
        <input type="text" name="patronymic" id="patronymicEdit" value="{{$user->patronymic}}" disabled>
        </div>
        <div class="d-flex justify-content-between m-1" style="width: 275px">
        <span id="oldPasswordSpan" hidden>Старый пароль:</span>
        <input type="password" name="oldPassword" id="oldPassword" hidden>
        </div>
        <div class="d-flex justify-content-between m-1" style="width: 275px">
        <span id="newPasswordSpan" hidden>Новый пароль:</span>
        <input type="password" name="newPassword" id="newPassword" hidden>
        </div>
    </div>
    <button id="prflEditBtn" class="btn btn-primary">Редактировать</button>
    <button type="submit" id="prflCnfrmdBtn" class="btn btn-success" hidden>Подтвердить</button>
    </form>
    <h2 class="mt-2">Ваши заказы</h2>
    <div class="scroll-table">
        <table>
            <thead>
                <tr>
                    <th>Товары</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Дата оформления</th>
                    <th>Действия</th>
                </tr>
            </thead>
        </table>
        <div class="scroll-table-body">
            <table>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>
                            @foreach ($order->orderProducts as $orderProduct)
                                <span>{{$orderProduct->product->full_name}}</span><br>
                            @endforeach
                        </td>
                        <td>{{$order->sum}}</td>
                        <td>{{$order->status->name}}</td>
                        <td>{{$order->created_at}}</td>
                        <td class="d-flex justify-content-around">
                            <form action="{{route('orders.destroy', $order->id)}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                  </svg></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', ()=>{
            let email = document.getElementById('emailEdit')
            let surname = document.getElementById('surnameEdit')
            let name = document.getElementById('nameEdit')
            let patronymic = document.getElementById('patronymicEdit')
            let oldPassword = document.getElementById('oldPassword')
            let oldPasswordSpan = document.getElementById('oldPasswordSpan')
            let newPassword = document.getElementById('newPassword')
            let newPasswordSpan = document.getElementById('newPasswordSpan')
            let prflEditBtn = document.getElementById('prflEditBtn')
            let prflCnfrmdBtn = document.getElementById('prflCnfrmdBtn')
            prflEditBtn.addEventListener('click', (e)=>{
                e.preventDefault()
                prflEditBtn.hidden = true
                prflCnfrmdBtn.hidden = false
                email.disabled = false
                surname.disabled = false
                name.disabled = false
                patronymic.disabled = false
                oldPassword.hidden = false
                newPassword.hidden = false
                oldPasswordSpan.hidden = false
                newPasswordSpan.hidden = false
            })
        })
    </script>
@endpush
