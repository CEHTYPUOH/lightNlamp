<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id'
    ];

    public $timestamps = false;

    public function models(){
        return $this->hasMany(ProductModel::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
