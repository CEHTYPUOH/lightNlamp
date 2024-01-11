<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(){
        return view('register.register');
    }

    public function store(RegisterRequest $request)
    {
        $user = User::create($request->only(['name', 'surname', 'patronymic', 'email', 'role_id']) + ['password'=>Hash::make($request->password)]);
        auth()->login($user);
        return to_route('orders');
    }

    public function update(Request $request, User $user)
    {
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->oldPassword])){
            if($request->newPassword == null){
                $user->update($request->only(['email', 'surname', 'name', 'patronymic']) + ['password'=>Hash::make($request->oldPassword)]);
            } else {
                $user->update($request->only(['email', 'surname', 'name', 'patronymic']) + ['password'=>Hash::make($request->newPassword)]);
            }
            return back();
        } else {
            return back()->withErrors(['pswrdErr'=>'Неправильно введён старый пароль']);
        }
    }

    public function login(LoginRequest $request){
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            $request->session()->regenerate();
            return to_route('orders');
        } else {
            return back()->withErrors(['invalidData'=>'Неверный адрес электронной почты или пароль']);
        }
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('products');
    }
}
