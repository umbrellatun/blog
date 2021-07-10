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

     public function Company()
     {
          return $this->hasOne(Company::class, 'id', 'company_id');
     }

     public function LaosDistrict()
     {
          return $this->hasOne(LaosDistrict::class, 'id', 'customer_district');
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

     public function TransferFirst()
     {
          return $this->hasOne(Transfer::class, 'order_id', 'id');
     }

     public function Currency()
     {
          return $this->hasOne(Currency::class, 'id', 'currency_id');
     }

     public function CreatedBy()
     {
          return $this->hasOne(\App\User::class, 'id', 'created_by');
     }


}
