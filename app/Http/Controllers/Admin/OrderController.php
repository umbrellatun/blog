<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Order;
use App\Models\RunNo;
use App\Models\Currency;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\LaosDistrict;
use App\Models\Product;

use App\User;
use Validator;

class OrderController extends Controller
{
     public function index()
     {
          $data["titie"] = "รายการสั่งซื้อ";
          $data["users"] = User::with('Role')->get();
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = Menu::with('SubMenu')->orderBy('sort', 'asc')->get();
          $data["orders"] = Order::get();
          return view('Admin.Order.list', $data);
     }

     public function create()
     {
          $data["titie"] = "เพิ่มคำสั่งซื้อ";
          $data["users"] = User::with('Role')->get();
          $data["menus"] = Menu::orderBy('sort', 'asc')->get();
          $data["currencies"] = Currency::get();
          $data["companies"] = Company::get();
          $data["shippings"] = Shipping::get();
          $data["customers"] = Customer::get();
          $data["laos_districts"] = LaosDistrict::get();
          $data["products"] = Product::with('ProductType')->get();
          $run_no = RunNo::where('prefix', '=', 'order')->first();
          $this_year = date('Y'); $this_month = date('m'); $this_day = date('d');
          $qty = 1;
          if ($run_no){
               if ($run_no->year != $this_year || $run_no->month != $this_month || $run_no->day != $this_day){
                    $qty = 1;
               } else {
                    $qty = $run_no->qty + 1;
               }
          }
          $data["order_no"] = $this_year.$this_month.$this_day . "-" . str_pad($qty, 3, "0", STR_PAD_LEFT) ;
          return view('Admin.Order.create', $data);
     }

     public function get_product(Request $request)
     {

          $product = Product::find($request->product_id);
          if ($product->in_stock >= $request->valueCurrent){
               $return["status"] = 1;
               $return["sku"] = $product->sku;
               $return["name"] = $product->name;
               $return["price_bath"] = $product->price_bath;
               $return["price_lak"] = $product->price_lak;
               $return["in_stock"] = $product->in_stock - $request->valueCurrent;
          } else {
               $return["status"] = 0;
               $return["content"] = "จำนวนสินค้าคงเหลือไม่เพียงพอ";
               $return["in_stock"] = 0;
               $return["amount"] = $product->in_stock;
          }
          return json_encode($return);
     }
}
