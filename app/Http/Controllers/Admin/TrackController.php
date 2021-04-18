<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Role;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RunNo;
use App\Models\Currency;
use App\Models\OrderProduct;
use App\Models\OrderBoxs;
use App\User;
use Validator;
use Storage;
use \Mpdf\Mpdf;

class TrackController extends Controller
{
     public function index($order_id)
    {
         $data["title"] = "ติดตามคำสั่งซื้อ";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = Menu::with(['SubMenu' => function($q){
              $q->orderBy('sort', 'asc');
         }])->orderBy('sort', 'asc')->get();
         $data["order"] = Order::with('OrderProduct.Product', 'OrderBoxs.Box', 'Transfer')->find($order_id);
         return view('Admin.Track.list', $data);
    }

    public function update(Request $request, $order_id)
    {
         $tracking_number = $request->tracking_number;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   
              } catch (Exception $e) {
                   \DB::rollBack();
                   $return['status'] = 0;
                   $return['content'] = 'สแกนไม่สำเร็จ'.$e->getMessage();
              }
         } else{
              $return['status'] = 0;
         }
         $return['title'] = '';
         return json_encode($return);
    }
}
