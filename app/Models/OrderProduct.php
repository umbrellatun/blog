<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
     protected $table = "order_products";

     public function Product()
     {
          return $this->hasOne(Product::class, 'id', 'product_id');
     }

     public function scopeSumOrderProduct($query)
     {
          return $query->sum('price_bath');
     }

     public function Order()
     {
          return $this->hasOne(Order::class, 'id', 'order_id');
     }

     public function CreatedBy()
     {
          return $this->hasOne(\App\User::class, 'id', 'created_by');
     }
}
