<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\User;
use App\Models\Menu;
use App\Models\Order;

class TransportController extends Controller
{
     public function index()
     {
          $data["titie"] = "รายการคำสั่งซื้อ";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = Menu::with(['SubMenu' => function($q){
               $q->orderBy('sort', 'asc');
          }])->orderBy('sort', 'asc')->get();
          $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->where('status', '=', 'P')->get();
          return view('Admin.Transport.list', $data);
     }
}
