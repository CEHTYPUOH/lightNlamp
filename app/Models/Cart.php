<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'quantity',
        'user_id',
        'product_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public static function getCart(){
        return auth()->user()->carts;
    }

    public static function destroyPos($user_id){
        Cart::where('user_id', $user_id)->delete();
    }

    public static function getProductById($id){
        return self::getCart()->where('product_id', $id)->first();
    }

    public function getSummaryAttribute(){
        return $this->product->price * $this->quantity;
    }
}
