<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelRequest;
use App\Models\Brand;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ModelController extends Controller
{
    public function index()
    {
        return view('admin.models.index', ['models' => ProductModel::all()]);
    }

    public function create()
    {
        return view('admin.models.create', ['brands' => Brand::all()]);
    }

    public function store(ModelRequest $request)
    {
        $isExist = ProductModel::where('name', $request->only(['name']))->get();
        if (count($isExist) == 0) {
            ProductModel::create($request->except(['_token']));
            return to_route('admin.models');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая модель уже есть в базе']);
        }
    }

    public function edit(ProductModel $model)
    {
        return view('admin.models.edit', ['model'=>$model, 'brands'=>Brand::all()]);
    }

    public function update(Request $request, ProductModel $model)
    {
        $isExist = ProductModel::where("name", $request->only(['name']))->get();
        if(count($isExist) == 0){
            $model->update($request->except(['_token']));
            return to_route('admin.models');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая модель уже есть в базе']);
        }
    }

    public function destroy(ProductModel $model)
    {
        $model->delete();
        return back();
    }

    public function showModelsByBrand(Request $request){
        return ProductModel::where('brand_id', $request->data[0])->get();
    }
}
