<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'subcategory_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
}
