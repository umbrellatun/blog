<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $table = "user_orders";

    public function Currency()
    {
         return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function Order()
    {
         return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
