<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSubcategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductSubcategoryController extends Controller
{
    public function index()
    {
        return view('admin.product_subcategories.index', ['products'=>Product::all()]);
    }

    public function create()
    {
        return view('admin.product_subcategories.create', ['products'=>Product::all(), 'categories'=>Category::all()]);
    }

    public function store(Request $request)
    {
        $isExist = ProductSubcategory::where([
            ['product_id', $request->only(['product_id'])],
            ['subcategory_id', $request->only(['subcategory_id'])]
            ])->get();
        if (count($isExist) == 0) {
            ProductSubcategory::create($request->except(['_token']));
            return to_route('admin.product_subcategories');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая подкатегория товара уже есть в базе']);
        }
    }

    public function changeCategory(Request $request)
    {
        return Subcategory::where('category_id', $request->data[0])->get();
    }
}
