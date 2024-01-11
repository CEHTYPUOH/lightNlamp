<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubcategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubcategoryController extends Controller
{
    public function index()
    {
        return view('admin.subcategories.index', ['subcategories'=>Subcategory::all()]);
    }

    public function create()
    {
        return view('admin.subcategories.create', ['categories'=>Category::all()]);
    }

    public function store(SubcategoryRequest $request)
    {
        $isExist = Subcategory::where('name', $request->only(['name']))->get();
        if (count($isExist) == 0) {
            Subcategory::create($request->except(['_token']));
            return to_route('admin.subcategories');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая подкатегория уже есть в базе']);
        }
    }

    public function show(Subcategory $subcategory)
    {
        return view('admin.subcategories.show', ['products'=>$subcategory->products]);
    }

    public function edit(Subcategory $subcategory)
    {
        return view('admin.subcategories.edit', ['subcategory'=>$subcategory, 'categories'=>Category::all()]);
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $isExist = Subcategory::where("name", $request->only(['name']))->where('category_id', $request->only(['category_id']))->get();
        if(count($isExist) == 0){
            $subcategory->update($request->except(['_token']));
            return to_route('admin.subcategories');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая подкатегория уже есть в базе']);
        }
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return back();
    }

    public function showSubcategoriesByCategory(Request $request)
    {
        return Subcategory::where('category_id', $request->data[0])->get();
    }

    public function showProdSubcategs(Request $request)
    {
        $product_id = $request->data;
        $product = Product::where('id', $product_id)->first();
        $subcategories_ids = [];
        foreach($product->subcategories as $subcategory){
            array_push($subcategories_ids, $subcategory->id);
        }
        return $subcategories_ids;
    }
}
