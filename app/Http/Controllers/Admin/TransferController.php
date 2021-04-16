<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Order;

use App\User;
use Validator;

class TransferController extends Controller
{
     public function index($order_id)
    {
         $data["titie"] = "รายการหลักฐานการโอนเงิน";
         $data["users"] = User::with('Role')->get();
         $data["menus"] = Menu::orderBy('sort', 'asc')->get();
         $data["order"] = Order::with('Transfer')->find($order_id);
         return view('Admin.Transfer.list', $data);
    }

    public function create($order_id)
    {
         $data["titie"] = "แนบสลิปการโอนเงิน";
         $data["users"] = User::with('Role')->get();
         $data["menus"] = Menu::orderBy('sort', 'asc')->get();
         $data["order"] = Order::with('Transfer')->find($order_id);
         return view('Admin.Transfer.create', $data);
    }

    public function store(Request $request, $order_id)
    {
         dd($request->all());
    }
}
