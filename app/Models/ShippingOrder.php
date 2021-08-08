<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingOrder extends Model
{
    protected $table = "shipping_orders";

    public function Order()
    {
         return $this->hasOne(Order::class, 'id', 'order_id');
    }

}
