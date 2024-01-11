<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories'=>Category::all()]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $isExist = Category::where('name', $request->only(['name']))->get();
        if (count($isExist) == 0) {
            Category::create($request->except(['_token',]));
            return to_route('admin.categories');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая категория уже есть в базе']);
        }
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', ['products'=>$category->subcategories[0]->products]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category'=>$category]);
    }

    public function update(Request $request, Category $category)
    {
        $isExist = Category::where("name", $request->only(['name']))->get();
        if(count($isExist) == 0){
            $category->update($request->except(['_token']));
            return to_route('admin.categories');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая категория уже есть в базе']);
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
