<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderTransferDetail extends Model
{
    protected $table = "user_order_transfer_details";

    public function User()
    {
         return $this->hasOne(\App\User::class, 'id', 'created_by');
    }
}
