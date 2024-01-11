<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        return view('profile.index', ['orders'=>Order::where('user_id', auth()->id())->get(), 'user'=>User::where('id', auth()->id())->first()]);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back();
    }
}
