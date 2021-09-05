<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    public function Company()
    {
         return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function ProductType()
    {
         return $this->hasOne(ProductType::class, 'id', 'product_type_id');
    }

    public function OrderProduct()
    {
         return $this->hasMany(OrderProduct::class, 'product_id', 'id');
    }

    public function ProductStock()
    {
         return $this->hasMany(ProductStock::class, 'product_id', 'id');
    }
}
