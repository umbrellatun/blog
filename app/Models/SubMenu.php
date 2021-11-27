<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = "submenu";

    public function Permission()
    {
         return $this->hasOne(Permission::class, 'submenu_id', 'id');
    }
}
