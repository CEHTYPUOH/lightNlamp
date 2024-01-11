<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CountryController extends Controller
{
    public function index()
    {
       return view('admin.countries.index', ['countries'=>Country::all()]);
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(CountryRequest $request)
    {
        $isExist = Country::where('name', $request->only(['name']))->get();
        // dd($isExist);
        if (count($isExist) == 0) {
            Country::create($request->except(['_token',]));
            return to_route('admin.countries');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая страна уже есть в базе']);
        }
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', ['country'=>$country]);
    }

    public function update(Request $request, Country $country)
    {
        $isExist = Country::where("name", $request->only(['name']))->get();
        if(count($isExist) == 0){
            $country->update($request->except(['_token']));
            return to_route('admin.countries');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая страна уже есть в базе']);
        }
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return back();
    }
}
