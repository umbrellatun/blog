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
use App\Models\Box;
use App\Models\OrderProduct;
use App\Models\OrderBoxs;

use App\User;
use \Mpdf\Mpdf;
use Validator;
use App\Repositories\MenuRepository;

class OrderController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index()
     {
          $data["titie"] = "รายการสั่งซื้อ";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = $this->menupos->getParentMenu();

          $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->get();
          // $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->where('status', '=', 'W')->get();
          return view('Admin.Order.list', $data);
     }

     public function create()
     {
          $data["titie"] = "เพิ่มคำสั่งซื้อ";
          $data["users"] = User::with('Role')->get();
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::get();
          $data["companies"] = Company::get();
          $data["shippings"] = Shipping::get();
          $data["customers"] = Customer::get();
          $data["laos_districts"] = LaosDistrict::get();
          $data["products"] = Product::with('ProductType')->get();
          $data["boxs"] = Box::where('use_flag', '=', 'Y')->get();
          // $run_no = RunNo::where('prefix', '=', 'order')->first();
          // $this_year = date('Y'); $this_month = date('m'); $this_day = date('d');
          // $qty = 1;
          // if ($run_no){
          //      if ($run_no->year != $this_year || $run_no->month != $this_month || $run_no->day != $this_day){
          //           $qty = 1;
          //      } else {
          //           $qty = $run_no->qty + 1;
          //      }
          // }
          // $data["order_no"] = $this_year.$this_month.$this_day . "-" . str_pad($qty, 3, "0", STR_PAD_LEFT) ;
          $data["order_no"] = 'PO-' . date('Ymd') . '-' . date('His');
          return view('Admin.Order.create', $data);
     }

     public function edit($id)
     {
          $data["titie"] = "แก้ไขคำสั่งซื้อ";
          $data["users"] = User::with('Role')->get();
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::get();
          $data["companies"] = Company::get();
          $data["shippings"] = Shipping::get();
          $data["customers"] = Customer::get();
          $data["laos_districts"] = LaosDistrict::get();
          $data["products"] = Product::with('ProductType')->get();
          $data["boxs"] = Box::where('use_flag', '=', 'Y')->get();
          $data["order"] = Order::with(['OrderProduct' => function($q){
                              $q->groupBy('order_products.product_id');
                              $q->with('Product');
                         }])
                         ->with(['OrderBoxs' => function($q){
                              $q->groupBy('order_boxs.box_id');
                              $q->with('Box');
                         }])->find($id);
          return view('Admin.Order.edit', $data);
     }

     public function manage($id)
     {
          $data["titie"] = "จัดการคำสั่งซื้อ";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();
          $data["order"] = Order::with('OrderProduct', 'OrderBoxs', 'Shipping')->with(['Transfer'])->find($id);

          return view('Admin.Order.manage', $data);
     }

     public function get_product(Request $request)
     {
          if ($request->product_id){
               $product = Product::find($request->product_id);
               if ($product->in_stock >= $request->valueCurrent){
                    $return["status"] = 1;
                    $return["product_id"] = $product->id;
                    $return["sku"] = $product->sku;
                    $return["name"] = $product->name;
                    $return["price_bath"] = $product->price_bath;
                    $return["price_lak"] = $product->price_lak;
                    $return["image"] = $product->image;
                    $return["in_stock"] = $product->in_stock - $request->valueCurrent;
                    $return["sum_bath"] = $product->price_bath * $request->valueCurrent;
                    $return["sum_lak"] = $product->price_lak * $request->valueCurrent;
               } else {
                    $return["status"] = 0;
                    $return["content"] = "จำนวนสินค้าคงเหลือไม่เพียงพอ";
                    $return["in_stock"] = 0;
                    $return["amount"] = $product->in_stock;
               }
          } else {
               $return["status"] = 0;
               $return["content"] = "ไม่พบ Product id";
          }
          return json_encode($return);
     }

     public function get_product2(Request $request)
     {
          if ($request->product_id){
               $product = Product::find($request->product_id);
               $order_product = OrderProduct::where('product_id', '=', $request->product_id)->first();
               if ($product->in_stock + $order_product->pieces  >= $request->valueCurrent){
                    $return["status"] = 1;
                    $return["product_id"] = $product->id;
                    $return["sku"] = $product->sku;
                    $return["name"] = $product->name;
                    $return["price_bath"] = $product->price_bath;
                    $return["price_lak"] = $product->price_lak;
                    $return["image"] = $product->image;
                    $return["in_stock"] = $product->in_stock + $order_product->pieces;
                    $return["sum_bath"] = $product->price_bath * $request->valueCurrent;
                    $return["sum_lak"] = $product->price_lak * $request->valueCurrent;
               } else {
                    $return["status"] = 0;
                    $return["content"] = "จำนวนสินค้าคงเหลือไม่เพียงพอ";
                    $return["in_stock"] = $product->in_stock + $order_product->pieces;
                    $return["amount"] = $product->in_stock + $order_product->pieces;
               }
          } else {
               $return["status"] = 0;
               $return["content"] = "ไม่พบ Product id";
          }
          return json_encode($return);
     }

     public function get_box(Request $request)
     {
          if ($request->box_id){
               $box = Box::find($request->box_id);
               if ($box->in_stock >= $request->valueCurrent){
                    $return["status"] = 1;
                    $return["box_id"] = $box->id;
                    $return["size"] = $box->size;
                    $return["description"] = $box->description;
                    $return["image"] = $box->image;
                    $return["in_stock"] = $box->in_stock - $request->valueCurrent;
                    $return["price_bath"] = $box->price_bath;
                    $return["price_lak"] = $box->price_lak;
                    $return["sum_bath"] = $box->price_bath * $request->valueCurrent;
                    $return["sum_lak"] = $box->price_lak * $request->valueCurrent;
               } else {
                    $return["status"] = 0;
                    $return["content"] = "จำนวนสินค้าคงเหลือไม่เพียงพอ";
                    $return["in_stock"] = 0;
                    $return["amount"] = $box->in_stock;
               }
          } else {
               $return["status"] = 0;
               $return["content"] = "ไม่พบ Box id";
          }
          return json_encode($return);
     }

     public function get_customer(Request $request)
     {
          $customer = Customer::find($request->customer_id);
          return $customer;
     }

     public function store(Request $request)
     {
          $order_no = $request->order_no;
          $currency_id = $request->currency_id;
          $company_id = $request->company_id;
          $discount = $request->discount;
          $note = $request->note;
          $customer_id = $request->customer_id;
          $customer_name = $request->customer_name;
          $customer_address = $request->customer_address;
          $customer_city = $request->customer_city;
          $laos_distict_id = $request->laos_distict_id;
          $customer_phone = $request->customer_phone;
          $shipping_id = $request->shipping_id;
          $shipping_cost = $request->shipping_cost;

          $product_ids = $request->product_id;
          $product_amounts = $request->product_amount;
          $box_ids = $request->box_id;
          $box_amounts = $request->box_amount;
          $validator = Validator::make($request->all(), [
               "shipping_id" => 'required',
               "product_id" => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    if(!isset($customer_id)){
                         $customer = Customer::where('name', '=', $customer_name)
                              ->where('address', '=', $customer_address)
                              ->where('city', '=', $customer_city)
                              ->where('district_id', '=', $laos_distict_id)
                              ->where('phone_number', '=', $customer_phone)
                              ->where('use_flag', '=', 'Y')
                              ->first();
                         if(!isset($customer)){
                              $data = [
                                   'name' => $customer_name
                                   ,'address' => $customer_address
                                   ,'city' => $customer_city
                                   ,'district_id' => $laos_distict_id
                                   ,'phone_number' => $customer_phone
                                   ,'use_flag' => 'Y'
                              ];
                              $customer_id = Customer::insertGetId($data);
                              $customer = Customer::find($customer_id);
                              $data = [
                                   'order_no' => $order_no
                                   ,'currency_id' => $currency_id
                                   ,'company_id' => $company_id
                                   ,'shipping_id' => $shipping_id
                                   ,'customer_id' => $customer->id
                                   ,'customer_name' => $customer->name
                                   ,'customer_address' => $customer->address
                                   ,'customer_city' => $customer->city
                                   ,'customer_district' => $customer->district_id
                                   ,'customer_phone_number' => $customer->phone_number
                                   ,'shipping_cost' => $shipping_cost
                                   ,'discount' => $discount
                                   ,'status' => 'W'
                                   ,'note' => $note
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              $order_id = Order::insertGetId($data);
                         } else {
                              $customer = Customer::find($customer->id);
                              $data = [
                                   'order_no' => $order_no
                                   ,'currency_id' => $currency_id
                                   ,'company_id' => $company_id
                                   ,'shipping_id' => $shipping_id
                                   ,'customer_id' => $customer->id
                                   ,'customer_name' => $customer->name
                                   ,'customer_address' => $customer->address
                                   ,'customer_city' => $customer->city
                                   ,'customer_district' => $customer->district_id
                                   ,'customer_phone_number' => $customer->phone_number
                                   ,'shipping_cost' => $shipping_cost
                                   ,'discount' => $discount
                                   ,'status' => 'W'
                                   ,'note' => $note
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              $order_id = Order::insertGetId($data);
                         }
                    } else {
                         $customer = Customer::find($customer_id);
                         $data = [
                              'order_no' => $order_no
                              ,'currency_id' => $currency_id
                              ,'company_id' => $company_id
                              ,'shipping_id' => $shipping_id
                              ,'customer_id' => $customer_id
                              ,'customer_name' => $customer->name
                              ,'customer_address' => $customer->address
                              ,'customer_city' => $customer->city
                              ,'customer_district' => $customer->district_id
                              ,'customer_phone_number' => $customer->phone_number
                              ,'shipping_cost' => $shipping_cost
                              ,'discount' => $discount
                              ,'status' => 'W'
                              ,'note' => $note
                              ,'created_by' => \Auth::guard('admin')->id()
                              ,'created_at' => date('Y-m-d H:i:s')
                         ];
                         $order_id = Order::insertGetId($data);
                    }

                    if ($order_id) {
                         for($i=0;$i<count($product_ids);$i++){
                              for ($j=1; $j <= $product_amounts[$i] ; $j++) {
                                   $product = Product::find($product_ids[$i]);
                                   $data = [
                                        'order_id' => $order_id
                                        ,'product_id' => $product->id
                                        ,'pieces' => $product_amounts[$i]
                                        ,'price_bath' => $product->price_bath
                                        ,'price_lak' => $product->price_lak
                                        ,'qr_code' => $order_no . '-' . $product_ids[$i] . '-' . $j . '/' . $product_amounts[$i]
                                        ,'sort' => $j
                                        ,'use_flag' => 'Y'
                                        ,'created_by' => \Auth::guard('admin')->id()
                                        ,'created_at' => date('Y-m-d H:i:s')
                                   ];
                                   $order_product_id = OrderProduct::insertGetId($data);
                              }
                              /* ตัดสต็อก */
                              if ($order_product_id){
                                   $data = [
                                        'in_stock' => $product->in_stock - $product_amounts[$i]
                                   ];
                                   Product::where('id', '=', $product_ids[$i])->update($data);
                              }
                         }
                         if ( isset($box_ids) ) {
                              for($i=0;$i<count($box_ids);$i++){
                                   for ($j=1; $j <= $box_amounts[$i] ; $j++) {
                                        $box = Box::find($box_ids[$i]);
                                        $data = [
                                             'order_id' => $order_id
                                             ,'box_id' => $box->id
                                             ,'pieces' => $box_amounts[$i]
                                             ,'price_bath' => $box->price_bath
                                             ,'price_lak' => $box->price_lak
                                             ,'qr_code' => $order_no . '-BOX-' . $product_ids[$i] . '-' . $j . '/' . $box_amounts[$i]
                                             ,'sort' => $j
                                             ,'use_flag' => 'Y'
                                             ,'created_by' => \Auth::guard('admin')->id()
                                             ,'created_at' => date('Y-m-d H:i:s')
                                        ];
                                        $order_box_id = OrderBoxs::insertGetId($data);
                                   }
                                   /* ตัดสต็อก */
                                   if ($order_box_id){
                                        $data = [
                                             'in_stock' => $box->in_stock - $box_amounts[$i]
                                        ];
                                        Box::where('id', '=', $box_ids[$i])->update($data);
                                   }
                              }
                         }

                    }
                    \DB::commit();
                    $return['status'] = 1;
                    $return['content'] = 'จัดเก็บสำเร็จ';
               } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
               $return['content'] = 'กรุณาระบุข้อมูลให้ครบถ้วน';
          }
          $return['title'] = 'เพิ่มข้อมูล';
          return json_encode($return);
     }

     public function update(Request $request, $id)
     {
          $order_no = $request->order_no;
          $currency_id = $request->currency_id;
          $company_id = $request->company_id;
          $discount = $request->discount;
          $note = $request->note;
          $customer_id = $request->customer_id;
          $customer_name = $request->customer_name;
          $customer_address = $request->customer_address;
          $customer_city = $request->customer_city;
          $laos_distict_id = $request->laos_distict_id;
          $customer_phone = $request->customer_phone;
          $shipping_id = $request->shipping_id;
          $shipping_cost = $request->shipping_cost;

          $product_ids = $request->product_id;
          $product_amounts = $request->product_amount;
          $box_ids = $request->box_id;
          $box_amounts = $request->box_amount;
          $validator = Validator::make($request->all(), [
               "shipping_id" => 'required',
               "product_id" => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $order = Order::find($id);
                    if(!isset($customer_id)){
                         $customer = Customer::where('name', '=', $customer_name)
                              ->where('address', '=', $customer_address)
                              ->where('city', '=', $customer_city)
                              ->where('district_id', '=', $laos_distict_id)
                              ->where('phone_number', '=', $customer_phone)
                              ->where('use_flag', '=', 'Y')
                              ->first();
                         if(!isset($customer)){
                              $data = [
                                   'name' => $customer_name
                                   ,'address' => $customer_address
                                   ,'city' => $customer_city
                                   ,'district_id' => $laos_distict_id
                                   ,'phone_number' => $customer_phone
                                   ,'use_flag' => 'Y'
                              ];
                              $customer_id = Customer::insertGetId($data);
                              $customer = Customer::find($customer_id);
                              $data = [
                                   'order_no' => $order_no
                                   ,'currency_id' => $currency_id
                                   ,'company_id' => $company_id
                                   ,'shipping_id' => $shipping_id
                                   ,'customer_id' => $customer->id
                                   ,'customer_name' => $customer->name
                                   ,'customer_address' => $customer->address
                                   ,'customer_city' => $customer->city
                                   ,'customer_district' => $customer->district_id
                                   ,'customer_phone_number' => $customer->phone_number
                                   ,'shipping_cost' => $shipping_cost
                                   ,'discount' => $discount
                                   ,'status' => 'W'
                                   ,'note' => $note
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              Order::where('id', '=', $id)->update($data);
                         } else {
                              $customer = Customer::find($customer->id);
                              $data = [
                                   'order_no' => $order_no
                                   ,'currency_id' => $currency_id
                                   ,'company_id' => $company_id
                                   ,'shipping_id' => $shipping_id
                                   ,'customer_id' => $customer->id
                                   ,'customer_name' => $customer->name
                                   ,'customer_address' => $customer->address
                                   ,'customer_city' => $customer->city
                                   ,'customer_district' => $customer->district_id
                                   ,'customer_phone_number' => $customer->phone_number
                                   ,'shipping_cost' => $shipping_cost
                                   ,'discount' => $discount
                                   ,'status' => 'W'
                                   ,'note' => $note
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              Order::where('id', '=', $id)->update($data);
                         }
                    } else {
                         $customer = Customer::find($customer_id);
                         $data = [
                              'currency_id' => $currency_id
                              ,'company_id' => $company_id
                              ,'shipping_id' => $shipping_id
                              ,'customer_id' => $customer_id
                              ,'customer_name' => $customer->name
                              ,'customer_address' => $customer->address
                              ,'customer_city' => $customer->city
                              ,'customer_district' => $customer->district_id
                              ,'customer_phone_number' => $customer->phone_number
                              ,'shipping_cost' => $shipping_cost
                              ,'discount' => $discount
                              ,'status' => 'W'
                              ,'note' => $note
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $id)->update($data);
                    }

                    OrderProduct::where('order_id', '=', $id)->delete();
                    for($i=0;$i<count($product_ids);$i++){
                         for ($j=1; $j <= $product_amounts[$i] ; $j++) {
                              $product = Product::find($product_ids[$i]);
                              $data = [
                                   'order_id' => $id
                                   ,'product_id' => $product->id
                                   ,'pieces' => $product_amounts[$i]
                                   ,'price_bath' => $product->price_bath
                                   ,'price_lak' => $product->price_lak
                                   ,'qr_code' => $order_no . '-' . $product_ids[$i] . '-' . $j . '/' . $product_amounts[$i]
                                   ,'sort' => $j
                                   ,'use_flag' => 'Y'
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              $order_product_id = OrderProduct::insertGetId($data);
                         }
                         /* ตัดสต็อก */
                         if ($order_product_id){
                              $data = [
                                   'in_stock' => $product->in_stock - $product_amounts[$i]
                              ];
                              Product::where('id', '=', $product_ids[$i])->update($data);
                         }
                    }

                    OrderBoxs::where('order_id', '=', $id)->delete();
                    if (isset($box_ids)) {
                         for($i=0;$i<count($box_ids);$i++){
                              for ($j=1; $j <= $box_amounts[$i] ; $j++) {
                                   $box = Box::find($box_ids[$i]);
                                   $data = [
                                        'order_id' => $id
                                        ,'box_id' => $box->id
                                        ,'pieces' => $box_amounts[$i]
                                        ,'price_bath' => $box->price_bath
                                        ,'price_lak' => $box->price_lak
                                        ,'qr_code' => $order_no . '-BOX-' . $product_ids[$i] . '-' . $j . '/' . $box_amounts[$i]
                                        ,'sort' => $j
                                        ,'use_flag' => 'Y'
                                        ,'created_by' => \Auth::guard('admin')->id()
                                        ,'created_at' => date('Y-m-d H:i:s')
                                   ];
                                   $order_box_id = OrderBoxs::insertGetId($data);
                              }
                              /* ตัดสต็อก */
                              if ($order_box_id){
                                   $data = [
                                        'in_stock' => $box->in_stock - $box_amounts[$i]
                                   ];
                                   Box::where('id', '=', $box_ids[$i])->update($data);
                              }
                         }
                    }
                    \DB::commit();
                    $return['status'] = 1;
                    $return['content'] = 'จัดเก็บสำเร็จ';
               } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
               $return['content'] = 'กรุณาระบุข้อมูลให้ครบถ้วน';
          }
          $return['title'] = 'แก้ไขข้อมูล';
          return json_encode($return);
     }

     public function qrcode($id)
     {
          $data['order'] = Order::with(['OrderProduct', 'OrderBoxs'])->find($id);
          $data2 = view('Admin.Order.qr_code', $data);
          $mpdf = new Mpdf([
               'autoLangToFont' => true,
               'mode' => 'utf-8',
               'format' => [101.6, 152.4],
               'margin_top' => 0,
               'margin_left' => 0,
               'margin_right' => 0,
               'margin_bottom' => 0,
          ]);
          // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
          $mpdf->WriteHTML($data2);
          $mpdf->Output('QrCode_'. $id .'_'. date('Y_m_d') .'.pdf', 'I');
     }

     public function coverSheet($id)
     {
          $data['order'] = Order::with(['OrderProduct', 'OrderBoxs'])->find($id);
          $data2 = view('Admin.Order.coverSheet', $data);
          $mpdf = new Mpdf([
               'autoLangToFont' => true,
               'mode' => 'utf-8',
               'format' => 'A4',
               'margin_top' => 0,
               'margin_left' => 0,
               'margin_right' => 0,
               'margin_bottom' => 0,
          ]);
          // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
          $mpdf->WriteHTML($data2);
          $mpdf->Output('QrCode_'. $id .'_'. date('Y_m_d') .'.pdf', 'I');
     }


}
