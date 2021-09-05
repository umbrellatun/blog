<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
     protected $table = "product_stocks";

     public function CreatedBy()
     {
          return $this->hasOne(\App\User::class, 'id', 'created_by');
     }
}
