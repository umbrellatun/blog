<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = "shippings";

    public function ShippingOrder()
    {
         return $this->hasMany(ShippingOrder::class, 'shipping_id', 'id');
    }
}
