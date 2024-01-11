<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_code',
        'price',
        'count',
        'model_id'
    ];

    public function getFullNameAttribute(){
        return $this->model->brand->name . ' ' . $this->model->name . ' ' . $this->vendor_code;
    }

    public function getProductCharacteristicValue($product_id, $characteristic_id){
        return ProductCharacteristic::select('value')->where('product_id', $product_id)->where('characteristic_id', $characteristic_id)->get();
    }

    public function getProductBrand(){
        return $this->model->brand->id;
    }

    public function getProductCategory(){
        return $this->subcategories->first()?->category->id;
    }

    public function getProductCategoryAttribute(){
        return $this->subcategories->first()?->category->name;
    }

    public function getProductImage(){
        return $this->images->first();
    }

    public function getProduct(){
        return $this;
    }

    public static function getProductById($product_id){
        return Product::find($product_id);
    }

    public function subcategories(){
        return $this->belongsToMany(Subcategory::class, 'product_subcategories');
    }

    public function productSubcategories(){
        return $this->hasMany(ProductSubcategory::class);
    }

    public function productCharacteristics(){
        return $this->hasMany(ProductCharacteristic::class);
    }

    public function characteristics(){
        return $this->belongsToMany(Characteristic::class, 'product_characteristics')->withPivot('value');
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function orders(){
        return $this->hasMany(OrderProduct::class);
    }

    public function model(){
        return $this->belongsTo(ProductModel::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
