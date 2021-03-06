<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
     protected $table = "companies";

     public function Province()
     {
          return $this->hasOne(Province::class, 'id', 'provinces_id');
     }

     public function Amphure()
     {
          return $this->hasOne(Amphure::class, 'id', 'amphures_id');
     }

     public function District()
     {
          return $this->hasOne(District::class, 'id', 'district');
     }

     public function Order()
     {
          return $this->hasMany(Order::class, 'company_id', 'id');
     }

     public function PartnerOrder()
     {
          return $this->hasMany(PartnerOrder::class, 'company_id', 'id');
     }
}
