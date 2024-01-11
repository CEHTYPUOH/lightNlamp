<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user'=>$this->user_id,
            'name'=>$this->product->full_name,
            'price'=>$this->product->price,
            'quantity'=>$this->quantity,
            'summary'=>$this->summary,
        ];
    }
}
