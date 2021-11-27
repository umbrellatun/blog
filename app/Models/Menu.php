<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
     protected $table = "menus";

     public function SubMenu()
     {
          return $this->hasMany(SubMenu::class, 'menu_id', 'id');
     }

     public function Permission()
     {
          return $this->hasOne(Permission::class, 'menu_id', 'id');
     }
}
