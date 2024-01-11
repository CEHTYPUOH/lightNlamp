<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CharacteristicRequest;
use App\Models\Characteristic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CharacteristicController extends Controller
{
    public function index()
    {
        return view('admin.characteristics.index', ['characteristics'=>Characteristic::all()]);
    }

    public function create()
    {
        return view('admin.characteristics.create');
    }

    public function store(CharacteristicRequest $request)
    {
        $isExist = Characteristic::where('name', $request->only(['name']))->get();
        if (count($isExist) == 0) {
            Characteristic::create($request->except(['_token',]));
            return to_route('admin.characteristics');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая характеристика уже есть в базе']);
        }
    }

    public function edit(Characteristic $characteristic)
    {
        return view('admin.characteristics.edit', ['characteristic'=>$characteristic]);
    }

    public function update(Request $request, Characteristic $characteristic)
    {
        $isExist = Characteristic::where("name", $request->only(['name']))->get();
        if(count($isExist) == 0){
            $characteristic->update($request->except(['_token']));
            return to_route('admin.characteristics');
        } else {
            return Redirect::back()->withErrors(['msg' => 'Такая характеристика уже есть в базе']);
        }
    }

    public function destroy(Characteristic $characteristic)
    {
        $characteristic->delete();
        return back();
    }

    public function getAllCharacters(Request $request){
        $characteristics = Characteristic::all();
        $charactersIds = [];
        foreach ($characteristics as $characteristic) {
            array_push($charactersIds, $characteristic->characteristic_id);
        }
        return $charactersIds;
    }
}
