<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerOrder extends Model
{
     protected $table = "partner_orders";

     public function Order()
     {
          return $this->hasOne(Order::class, 'id', 'order_id');
     }
}
