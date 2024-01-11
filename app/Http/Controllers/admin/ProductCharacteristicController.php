<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCharacteristicRequest;
use App\Models\Characteristic;
use App\Models\Product;
use App\Models\ProductCharacteristic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductCharacteristicController extends Controller
{
    public function index()
    {
        return view('admin.product_characteristics.index', ['products' => Product::all()]);
    }

    public function create()
    {
        return view('admin.product_characteristics.create', ['products' => Product::all(), 'characteristics' => Characteristic::all()]);
    }

    public function store(ProductCharacteristicRequest $request)
    {
        $isExist = ProductCharacteristic::where([['product_id', $request->only(['product_id'])], ['characteristic_id', $request->only(['characteristic_id'])]])->get();
        if (count($isExist) == 0) {
            ProductCharacteristic::create($request->except(['_token']));
            return to_route('admin.product_characteristics');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая характеристика товара уже есть в базе']);
        }
    }
}
