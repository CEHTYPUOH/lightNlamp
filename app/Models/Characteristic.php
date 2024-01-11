<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function getCharacteristicIdAttribute(){
        return $this->id;
    }

    public function productCharacteristics(){
        return $this->hasMany(ProductCharacteristic::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
