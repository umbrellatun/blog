<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
     protected $table = "transfer";

     public function Order()
     {
          return $this->hasOne(Order::class, 'id', 'order_id');
     }

     public function User()
     {
          return $this->hasOne(\App\User::class, 'id', 'payee_id');
     }

     public function Currency()
     {
          return $this->hasOne(Currency::class, 'id', 'currency_id');
     }
}
