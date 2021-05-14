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

use App\Repositories\MenuRepository;

class InvoiceController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index($order_id)
     {
          $data["titie"] = "ใบแจ้งหนี้";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = $this->menupos->getParentMenu();

          $data["order"] = $order = Order::with('OrderProduct.Product')
                                   ->with('OrderBoxs.Box')
                                   ->with('Transfer')
                                   ->with('LaosDistrict')
                                   ->with('Company.Province')
                                   ->with('Company.Amphure')
                                   ->find($order_id);
          $total_price = 0;
          foreach ($order->OrderProduct as $order_product){
               $total_price += $order_product->price_bath;
          }

          $data["total_price"] = $total_price;
          return view('Admin.Invoice.list', $data);
     }
}
