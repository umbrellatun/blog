<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $table = "customers";

     public function LaosDistrict()
     {
          return $this->hasOne(LaosDistrict::class, 'id', 'district_id');
     }
}
