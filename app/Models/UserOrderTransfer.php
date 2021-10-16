<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderTransfer extends Model
{
    protected $table = "user_order_transfers";

    public function User()
    {
         return $this->hasOne(\App\User::class, 'id', 'created_by');
    }

    public function UserOrder()
    {
         return $this->hasMany(UserOrder::class, 'user_order_transfer_id', 'id');
    }
}
