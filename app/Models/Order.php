<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $table = "orders";

     public function Customer()
     {
          return $this->hasOne(Customer::class, 'id', 'customer_id');
     }

     public function Shipping()
     {
          return $this->hasOne(Shipping::class, 'id', 'shipping_id');
     }

     public function OrderProduct()
     {
          return $this->hasMany(OrderProduct::class, 'order_id', 'id');
     }

     public function OrderBoxs()
     {
          return $this->hasMany(OrderBoxs::class, 'order_id', 'id');
     }

     public function Transfer()
     {
          return $this->hasMany(Transfer::class, 'order_id', 'id');
     }

}
