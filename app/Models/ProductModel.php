<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'brand_id'
    ];


    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
