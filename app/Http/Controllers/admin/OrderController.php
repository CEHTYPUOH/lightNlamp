<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Status;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', ['orders' => Order::all()]);
    }

    public function show($id)
    {
        return view('admin.orders.show', ['orders'=>OrderProduct::where('order_id', $id)->get()]);
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', ['order' => $order, 'statuses' => Status::all()]);
    }

    public function update(Request $request, Order $order)
    {
        $order->update(['status_id'=>$request->status_id]);
        return to_route('admin.orders');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back();
    }
}
