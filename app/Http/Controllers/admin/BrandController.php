<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    public function index()
    {
        return view("admin.brands.index", ['brands' => Brand::all()]);
    }

    public function create()
    {
        return view('admin.brands.create', ['countries'=>Country::all()]);
    }

    public function store(BrandRequest $request)
    {
        $isExist = Brand::where('name', $request->only(['name', 'country_id']))->get();
        if (count($isExist) == 0) {
            Brand::create($request->except(['_token',]));
            return to_route('admin.brands');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такой брэнд уже есть в базе']);
        }
    }

    public function edit(Brand $brand)
    {
        return view("admin.brands.edit", ['brand'=>$brand, 'countries' => Country::all(),]);
    }

    public function update(Request $request, Brand $brand)
    {
        $isExist = Brand::where("name", $request->only(['name', 'country_id']))->get();
        if(count($isExist) == 0){
            $brand->update($request->except(['_token']));
            return to_route('admin.brands');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такой брэнд уже есть в базе']);
        }
    }

    public function destroy($brand)
    {
        Brand::destroy($brand);
        return back();
    }
}
