<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CartController extends Controller
{
    public function index()
    {
        $orders = Cart::all();
        $total_amount = 0;
        foreach($orders as $order){
            if($order->user_id == auth()->id()){
                $total_amount += $order->quantity;
            }
        }
        return view('cart.index', ['orders'=>$orders, 'products'=>Product::all(), 'total_amount'=>$total_amount,]);
    }

    public function add(Request $request)
    {
        $cartProduct = Cart::getProductById($request->data);
        if($cartProduct == Null){
            $cartProduct = Cart::create([
                'user_id'=>auth()->id(), //auth()->user()->id
                'product_id'=>$request->data,
                'quantity'=>1,
            ]);
        } else { //Иначе увеличиваем кол-во в корзине
            $product = Product::find($request->data);
            if($cartProduct->quantity < $product->count){
                $cartProduct->quantity++;
                $cartProduct->save();
            }
        }
        return new CartResource($cartProduct);
    }

    public function remove(Request $request){
        $cartProduct = Cart::getProductById($request->data);
        $cartProduct->quantity--;
        $cartProduct->save();
        return new CartResource($cartProduct);
    }

    public function destroy(Request $request)
    {
        $cartProduct = Cart::getProductById($request->data);
        $cartProduct->delete();
        return true;
    }

    public function doOrder(Request $request){
            $total_price = 0;
            $arr = Cart::getCart();
            foreach($arr as $item){
                $product = Product::getProductById($item->product_id);
                $price = $product->price * $item->quantity;
                $total_price += $price;
            }
            $order = Order::create(['sum'=>$total_price, 'user_id'=>auth()->id()]);
            foreach($arr as $item){
                OrderProduct::create(['amount'=>$item->quantity, 'order_id'=>$order->id, 'product_id'=>$item->product_id]);
                $product = Product::getProductById($item->product_id);
                $product->count = $product->count - $item->quantity;
                $product->save();
            }
            Cart::destroyPos(auth()->id());
            return 0;
    }
}
