<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Product;
use App\Models\ProductSubcategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productsInCart = Cart::where('user_id', auth()->id())->get();
        $addedProducts = [];
        foreach($productsInCart as $product){
            array_push($addedProducts, $product->product->id);
        }
        $sort = [];
        $products = [];
        $category_id = $request->category_id;
        $subcategory_id = json_decode($request->subcategory_id);
        $filter_products = $request->filter_products;
        $selectedProducts = [];
        $selectedSubcategories = [];
        $choosenCategories = [];
        $choosenSubcategories = [];
        if($category_id != null){
            $products = Product::all();
        }
        elseif ($category_id == null && $subcategory_id != null){
            if(is_array($subcategory_id)){
                foreach($subcategory_id as $subcategory){
                    array_push($selectedSubcategories, $subcategory->id);
                }
                $subcategory_id = Subcategory::whereIn('id', $selectedSubcategories)->get();
            } else {
                array_push($selectedSubcategories, $subcategory_id);
                $subcategory_id = Subcategory::whereIn('id', [$selectedSubcategories])->get();
            }
            $choosenCategories = $subcategory_id[0]->category;
            foreach($subcategory_id as $subcategory){
                array_push($choosenSubcategories, $subcategory);
                $selectedProducts = $subcategory->products;
                foreach($selectedProducts as $product){
                    in_array($product, $products) ? '' : array_push($products, $product);
                }
            }
        } else {
            $products = Product::all();
        }
        if($filter_products != null){
            if($request->sort == "decs"){
                $products = $request->sortBy == "date" ? $products->sortByDesc('created_at') : $products->sortByDesc('price');
            } else {
                $products = $request->sortBy == "date" ? $products->sortBy('created_at') : $products->sortBy('price');
            }
            $sort = [$request->sort, $request->sortBy];
        }
        return view('index', ['products'=>$products,
                                'categories'=>Category::all(),
                                'subcategories'=>Subcategory::all(),
                                'choosenCategories'=>$choosenCategories,
                                'choosenSubcategories'=>$choosenSubcategories,
                                'addedProducts'=>$addedProducts,
                                'sort'=>$sort]);
    }

    public function show(Product $product)
    {
        $productsInCart = Cart::where('user_id', auth()->id())->get();
        $addedProducts = [];
        foreach($productsInCart as $productInCart){
            array_push($addedProducts, $productInCart->product->id);
        }
        return view('products.show', ['product'=>$product, 'characteristics'=>Characteristic::all(), 'addedProducts'=>$addedProducts]);
    }
}
