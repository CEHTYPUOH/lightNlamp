<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'email',
        'password',
        'role_id'
    ];

    public static function isAdmin($user)
    {
        if($user->role_id == 2){
            return true;
        } else {
            return false;
        }
    }

    public static function getPassword($user_id){
        return User::where('id', $user_id)->first();
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }
}
