<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\FileService;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductCharacteristic;
use App\Models\ProductModel;
use App\Models\ProductSubcategory;
use App\Models\Subcategory;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', ['products' => Product::all()]);
    }

    public function create()
    {
        return view(
            'admin.products.create',
            [
                'brands' => Brand::all(),
                'categories' => Category::all(),
                'models' => ProductModel::all(),
                'characteristics' => Characteristic::all()
            ]
        );
    }

    public function store(ProductRequest $request)
    {
        $productExist = Product::where('vendor_code', $request->vendor_code)->get();

        if (count($productExist) === 0) {
            $product = Product::create($request->except(['_token', 'brand_id', 'category_id', 'subcategories', 'urls', 'characteristics']));

            $product->subcategories()->attach($request->subcategories);

            FileService::upload($request->file('urls'), '/products', $product->id);

            $characteristics_id = $request->characteristics_id;
            $i = 0;
            foreach ($request->characteristics as $characteristic) {
                if ($characteristic) {
                    ProductCharacteristic::create([
                        'product_id' => $product->id,
                        'characteristic_id' => $characteristics_id[$i],
                        'value' => $characteristic
                    ]);
                }
                $i++;
            }
            return to_route('admin.products');
        }
        return back()->withErrors(['msg' => 'Такой товар уже есть']);
    }

    public function show(Product $product)
    {
        return view('admin.products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'brands' => Brand::all(),
            'models' => ProductModel::all(),
            'categories' => Category::all(),
            'subcategories' => Subcategory::all(),
            'productSubcategories' => $product->subcategories,
            'images' => $product->images,
            'productCharacteristics' => $product->productCharacteristics
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        if($request->file('urls') != null){
            FileService::upload($request->file('urls'), '/products', $product->id);
        }
        foreach ($request->only(['subcategories']) as $subcategory) {
            if (count(ProductSubcategory::where('product_id', $product->id)->where('subcategory_id', $subcategory)->get()) == 0) {
                ProductSubcategory::create(['product_id' => $product->id, 'subcategory_id' => $subcategory]);
            }
        }
        $prodCharacteristics_id = $request->prodCharacteristics_id;
        $i = 0;
        foreach ($request->characteristics as $characteristic){
            $prodCharacteristic = ProductCharacteristic::where('product_id', $product->id)->where('characteristic_id', $prodCharacteristics_id[$i])->first();
            if($prodCharacteristic != null){
                $prodCharacteristic->update(['product_id'=>$product->id, 'characteristic_id'=>$prodCharacteristics_id[$i], 'value'=>$characteristic]);
            }
            $i++;
        }
        $product->update($request->except(['_token', 'brand_id', 'category_id', 'subcategories', 'urls', 'characteristics', 'prodCharacteristics_id']));
        return to_route('admin.products');
    }

    public function destroy(Product $product)
    {
        FileService::delete($product->images);
        $product->delete();
        return back();
    }
}
