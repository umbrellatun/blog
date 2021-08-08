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
use App\Models\Settings;
use App\Models\Transfer;

use App\User;
use \Mpdf\Mpdf;
use Validator;
use Storage;

use App\Repositories\MenuRepository;

class OrderController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index(Request $request)
     {
          $data["titie"] = "รายการสั่งซื้อ";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = $this->menupos->getParentMenu();
          $data["shippings"] = Shipping::where('status', 'Y')->get();

          $orders = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs']);
          if ($request->all()){
               // dd($request->all());
               $status = $request->status;
               if ($status == 'A'){
                    $orders->where(function($q)use($status){
                         $q->whereNotNull('status');
                    });
               } else {
                    $orders->where(function($q)use($status){
                         $q->where('status', '=', $status);
                    });
               }
               // } elseif ($status == 'W') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // } elseif ($status == 'WA') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // } elseif ($status == 'P') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // } elseif ($status == 'FP') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // } elseif ($status == 'WT') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // } elseif ($status == 'T') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // } elseif ($status == 'S') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // } elseif ($status == 'C') {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // }

               $document_status = $request->document_status;
               if ($document_status == 1){
                    $orders->where(function($q)use($document_status){
                         $q->where('picklist_sheet', '!=', 'Y');
                         $q->where('cover_sheet', '!=', 'Y');
                    });
               } elseif($document_status == 2) {
                    $orders->where(function($q)use($document_status){
                         $q->where('picklist_sheet', '!=', 'Y');
                         $q->where('cover_sheet', '=', 'Y');
                    });
               } elseif($document_status == 3) {
                    $orders->where(function($q)use($document_status){
                         $q->where('picklist_sheet', '=', 'Y');
                         $q->where('cover_sheet', '!=', 'Y');
                    });
               }
          }
          $data["orders"] = $orders->paginate(10)->appends(request()->query());
          // $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->where('status', '=', 'W')->get();
          return view('Admin.Order.list', $data);
     }

     public function create()
     {
          $data["titie"] = "เพิ่มคำสั่งซื้อ";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["users"] = User::with('Role')->get();
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::where('use_flag', 'Y')->get();
          $data["companies"] = Company::where('use_flag', 'Y')->get();
          $data["shippings"] = Shipping::where('status', 'Y')->get();
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
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
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
                         }])
                         ->with(['TransferFirst'])
                         ->find($id);
          $data["titie"] = "แก้ไขคำสั่งซื้อ " . $data["order"]->order_no;

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
                    $return["price_usd"] = $product->price_usd;
                    $return["price_khr"] = $product->price_khr;
                    $return["image"] = $product->image;
                    $return["in_stock"] = $product->in_stock - $request->valueCurrent;
                    $return["sum_bath"] = $product->price_bath * $request->valueCurrent;
                    $return["sum_lak"] = $product->price_lak * $request->valueCurrent;
                    $return["sum_usd"] = $product->price_usd * $request->valueCurrent;
                    $return["sum_khr"] = $product->price_khr * $request->valueCurrent;
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
                    $return["price_usd"] = $product->price_usd;
                    $return["price_khr"] = $product->price_khr;
                    $return["image"] = $product->image;
                    $return["in_stock"] = $product->in_stock + $order_product->pieces;
                    $return["sum_bath"] = $product->price_bath * $request->valueCurrent;
                    $return["sum_lak"] = $product->price_lak * $request->valueCurrent;
                    $return["sum_usd"] = $product->price_usd * $request->valueCurrent;
                    $return["sum_khr"] = $product->price_khr * $request->valueCurrent;
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
                    $return["price_usd"] = $box->price_usd;
                    $return["price_khr"] = $box->price_khr;
                    $return["sum_bath"] = $box->price_bath * $request->valueCurrent;
                    $return["sum_lak"] = $box->price_lak * $request->valueCurrent;
                    $return["sum_usd"] = $box->price_usd * $request->valueCurrent;
                    $return["sum_khr"] = $box->price_khr * $request->valueCurrent;
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

          $transfer_price = $request->transfer_price;
          $transfer_currency_id = $request->transfer_currency_id;
          $transfer_date = $request->transfer_date;
          $hours = $request->hours;
          $minutes = $request->minutes;
          $transfer_cod_amount = $request->transfer_cod_amount;
          $transfer_note = $request->transfer_note;
          $validator = Validator::make($request->all(), [

          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $company = Company::find($company_id);
                    $cod = 0;
                    if ($shipping_id == 1) {
                         $total = 0;
                         for($i=0;$i<count($product_ids);$i++){
                              for ($j=1; $j <= $product_amounts[$i] ; $j++) {
                                   $product = Product::find($product_ids[$i]);
                                   if ($currency_id == 1){
                                        $total += $product->price_bath;
                                   }
                                   if ($currency_id == 2){
                                        $total += $product->price_lak;
                                   }
                                   if ($currency_id == 3){
                                        $total += $product->price_usd;
                                   }
                                   if ($currency_id == 4){
                                        $total += $product->price_khr;
                                   }
                              }
                         }
                         $cod = $total * ($company->delivery / 100);
                    }
                    if ($request->hasFile('image')) {
                         if(empty($request->transfer_price)){
                              $return["status"] = 0;
                              $return['content'] = 'กรุณาระบุยอดที่โอน';
                              $return['attr'] = 'transfer_price';

                              return json_encode($return);
                         }
                         $image      = $request->file('image');
                         $fileName   = time() . '.' . $image->getClientOriginalExtension();
                         $img = \Image::make($image->getRealPath());
                         // $img->resize(120, 120, function ($constraint) {
                         //      $constraint->aspectRatio();
                         // });
                         $img->stream();
                         $status = 'P';
                    } else {
                         $fileName = '';
                         $status = 'W';
                    }
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
                                   ,'status' => $status
                                   ,'note' => $note
                                   ,'pick' => $company->pick
                                   ,'pack' => $company->pack
                                   ,'delivery' => $cod
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
                                   ,'status' => $status
                                   ,'note' => $note
                                   ,'pick' => $company->pick
                                   ,'pack' => $company->pack
                                   ,'delivery' => $cod
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              $order_id = Order::insertGetId($data);
                         }

                         if ($request->hasFile('image')) {
                              $data = [
                                   'order_id' => $order_id
                                   ,'image' => $fileName
                                   ,'amount' => $transfer_price
                                   ,'currency_id' => $transfer_currency_id
                                   ,'transfer_date' => date_format($transfer_date, 'Y-m-d')
                                   ,'transfer_hours' => $hours
                                   ,'transfer_minutes' => $minutes
                                   ,'remark' => $transfer_note
                                   ,'status' => 'Y'
                                   ,'payee_id' => \Auth::guard('admin')->id()
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              $transfer_id = Transfer::insertGetId($data);
                              if ($transfer_id){
                                   Storage::disk('uploads')->put('transfers/'.$fileName, $img, 'public');
                              }
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
                              ,'status' => $status
                              ,'note' => $note
                              ,'pick' => $company->pick
                              ,'pack' => $company->pack
                              ,'delivery' => $cod
                              ,'cod_amount' => $transfer_cod_amount
                              ,'created_by' => \Auth::guard('admin')->id()
                              ,'created_at' => date('Y-m-d H:i:s')
                         ];
                         $order_id = Order::insertGetId($data);
                    }
                    if ($order_id) {
                         if ($request->hasFile('image')) {
                              $data = [
                                   'order_id' => $order_id
                                   ,'image' => $fileName
                                   ,'amount' => $transfer_price
                                   ,'currency_id' => $transfer_currency_id
                                   ,'transfer_date' => date_format(date_create($transfer_date), 'Y-m-d')
                                   ,'transfer_hours' => $hours
                                   ,'transfer_minutes' => $minutes
                                   ,'remark' => $transfer_note
                                   ,'status' => 'Y'
                                   ,'payee_id' => \Auth::guard('admin')->id()
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              $transfer_id = Transfer::insertGetId($data);
                              if ($transfer_id){
                                   Storage::disk('uploads')->put('transfers/'.$fileName, $img, 'public');
                              }
                         }
                         for($i=0;$i<count($product_ids);$i++){
                              for ($j=1; $j <= $product_amounts[$i] ; $j++) {
                                   $product = Product::find($product_ids[$i]);
                                   $data = [
                                        'order_id' => $order_id
                                        ,'product_id' => $product->id
                                        ,'pieces' => $product_amounts[$i]
                                        ,'price_bath' => $product->price_bath
                                        ,'price_lak' => $product->price_lak
                                        ,'price_usd' => $product->price_usd
                                        ,'price_khr' => $product->price_khr
                                        ,'qr_code' => $order_no . '-' . $product_ids[$i] . '-' . $j . '/' . $product_amounts[$i]
                                        ,'sort' => $j
                                        ,'use_flag' => 'Y'
                                        ,'status' => 'W'
                                        ,'created_by' => \Auth::guard('admin')->id()
                                        ,'created_at' => date('Y-m-d H:i:s')
                                   ];
                                   $order_product_id = OrderProduct::insertGetId($data);
                              }
                              /* ตัดสต็อก */
                              // if ($order_product_id){
                              //      $data = [
                              //           'in_stock' => $product->in_stock - $product_amounts[$i]
                              //      ];
                              //      Product::where('id', '=', $product_ids[$i])->update($data);
                              // }
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
                                             ,'price_usd' => $product->price_usd
                                             ,'price_khr' => $product->price_khr
                                             ,'qr_code' => $order_no . '-BOX-' . $product_ids[$i] . '-' . $j . '/' . $box_amounts[$i]
                                             ,'sort' => $j
                                             ,'use_flag' => 'Y'
                                             ,'status' => 'W'
                                             ,'created_by' => \Auth::guard('admin')->id()
                                             ,'created_at' => date('Y-m-d H:i:s')
                                        ];
                                        $order_box_id = OrderBoxs::insertGetId($data);
                                   }
                                   /* ตัดสต็อก */
                                   // if ($order_box_id){
                                   //      $data = [
                                   //           'in_stock' => $box->in_stock - $box_amounts[$i]
                                   //      ];
                                   //      Box::where('id', '=', $box_ids[$i])->update($data);
                                   // }
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
                    $company = Company::find($company_id);
                    $cod = 0;
                    if ($shipping_id == 1) {
                         $total = 0;
                         for($i=0;$i<count($product_ids);$i++){
                              for ($j=1; $j <= $product_amounts[$i] ; $j++) {
                                   $product = Product::find($product_ids[$i]);
                                   if ($currency_id == 1){
                                        $total += $product->price_bath;
                                   }
                                   if ($currency_id == 2){
                                        $total += $product->price_lak;
                                   }
                                   if ($currency_id == 3){
                                        $total += $product->price_usd;
                                   }
                                   if ($currency_id == 4){
                                        $total += $product->price_khr;
                                   }
                              }
                         }
                         $cod = $total * ($company->delivery / 100);
                    }
                    if ($request->hasFile('image')) {
                         if(empty($request->transfer_price)){
                              $return["status"] = 0;
                              $return['content'] = 'กรุณาระบุยอดที่โอน';
                              $return['attr'] = 'transfer_price';

                              return json_encode($return);
                         }
                         $image      = $request->file('image');
                         $fileName   = time() . '.' . $image->getClientOriginalExtension();
                         $img = \Image::make($image->getRealPath());
                         // $img->resize(120, 120, function ($constraint) {
                         //      $constraint->aspectRatio();
                         // });
                         $img->stream();
                         $status = 'P';
                    } else {
                         $fileName = '';
                         $status = 'W';
                    }
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
                                   ,'status' => $status
                                   ,'note' => $note
                                   ,'pick' => $company->pick
                                   ,'pack' => $company->pack
                                   ,'delivery' => $cod
                                   ,'cod_amount' => $request->transfer_cod_amount
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
                                   ,'status' => $status
                                   ,'note' => $note
                                   ,'pick' => $company->pick
                                   ,'pack' => $company->pack
                                   ,'delivery' => $cod
                                   ,'cod_amount' => $request->transfer_cod_amount
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
                              ,'status' => $status
                              ,'note' => $note
                              ,'pick' => $company->pick
                              ,'pack' => $company->pack
                              ,'delivery' => $cod
                              ,'cod_amount' => $request->transfer_cod_amount
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
                                   ,'price_usd' => $product->price_usd
                                   ,'price_khr' => $product->price_khr
                                   ,'qr_code' => $order_no . '-' . $product_ids[$i] . '-' . $j . '/' . $product_amounts[$i]
                                   ,'sort' => $j
                                   ,'use_flag' => 'Y'
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              $order_product_id = OrderProduct::insertGetId($data);
                         }
                         /* ตัดสต็อก */
                         // if ($order_product_id){
                         //      $data = [
                         //           'in_stock' => $product->in_stock - $product_amounts[$i]
                         //      ];
                         //      Product::where('id', '=', $product_ids[$i])->update($data);
                         // }
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
                                        ,'price_usd' => $box->price_usd
                                        ,'price_khr' => $box->price_khr
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

                    if ($request->hasFile('image')) {
                         $transfer = Transfer::find($request->transfer_id);
                         $image = $request->file('image');
                         $fileName = time() . '.' . $image->getClientOriginalExtension();
                         $img = \Image::make($image->getRealPath());
                         // $img->resize(120, 120, function ($constraint) {
                         //      $constraint->aspectRatio();
                         // });
                         $img->stream();
                         if (Storage::disk("uploads")->exists("transfers/".$transfer->image)){
                              Storage::disk("uploads")->delete("transfers/".$transfer->image);
                         }
                         Storage::disk('uploads')->put('transfers/'.$fileName, $img, 'public');
                         $data = [
                             'image' => $fileName
                             ,'amount' => $request->transfer_price
                             ,'currency_id' => $request->transfer_currency_id
                             ,'transfer_date' => $request->transfer_date
                             ,'transfer_hours' => $request->hours
                             ,'transfer_minutes' => $request->minutes
                             ,'remark' => $request->transfer_note
                             ,'status' => 'Y'
                             ,'updated_by' => \Auth::guard('admin')->id()
                             ,'updated_at' => date('Y-m-d H:i:s')
                        ];
                    } else {
                         $data = [
                             'amount' => $request->transfer_price
                             ,'currency_id' => $request->transfer_currency_id
                             ,'transfer_date' => $request->transfer_date
                             ,'transfer_hours' => $request->hours
                             ,'transfer_minutes' => $request->minutes
                             ,'remark' => $request->transfer_note
                             ,'status' => 'Y'
                             ,'updated_by' => \Auth::guard('admin')->id()
                             ,'updated_at' => date('Y-m-d H:i:s')
                        ];
                    }
                    Transfer::where('id', '=', $request->transfer_id)->update($data);
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
          $data['order'] = $order = Order::with(['Currency', 'OrderProduct', 'OrderBoxs', 'Shipping'])->find($id);
          if ($order->currency_id == 1) {
               $data["sum_price"] = $order->OrderProduct->sum('price_bath') + $order->OrderBoxs->sum('price_bath');
          }elseif($order->currency_id == 2){
               $data["sum_price"] = $order->OrderProduct->sum('price_lak') + $order->OrderBoxs->sum('price_lak');
          }elseif($order->currency_id == 3){
               $data["sum_price"] = $order->OrderProduct->sum('price_usd') + $order->OrderBoxs->sum('price_usd');
          }elseif($order->currency_id == 4){
               $data["sum_price"] = $order->OrderProduct->sum('price_khr') + $order->OrderBoxs->sum('price_khr');
          }

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

     public function coverSheetGroup($id)
     {
          // code...
     }

     public function get_product_company(Request $request)
     {
          $data["products"] = Product::where('company_id', '=', $request->company_id)->with('ProductType')->get();
          return json_encode($data);
     }

     public function adjustStatus(Request $request)
     {
          $status = $request->status;
          $order_id = $request->order_id;
          $validator = Validator::make($request->all(), [

          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $data = [
                         'status' => $status
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                    ];
                    Order::where('id', '=', $order_id)->update($data);
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

     public function adjustStatusMultiOrder(Request $request)
     {
          $order_ids = $request->order_ids;
          $validator = Validator::make($request->all(), [
               "order_ids" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    foreach ($order_ids as $order_id) {
                         $data = [
                              'status' => 'WT'
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $order_id)->update($data);
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
               $return['content'] = '';
          }
          $return['title'] = '';
          return json_encode($return);
     }

     public function GetOrderStatus($status)
     {
          if ($status == 'W') {
               $txt_status = 'รอหลักฐานการชำระเงิน';
          } elseif ($status == 'WA') {
               $txt_status = 'รอตรวจสอบหลักฐานการชำระเงิน';
          } elseif ($status == 'P') {
               $txt_status = 'รอแพ็คสินค้า';
          } elseif ($status == 'FP') {
               $txt_status = 'สแกนครบแล้ว';
          } elseif ($status == 'WT') {
               $txt_status = 'รอขนส่งเข้ามารับสินค้า';
          } elseif ($status == 'T') {
               $txt_status = 'อยู่ระหว่างจัดส่ง';
          } elseif ($status == 'S') {
               $txt_status = 'สำเร็จ';
          } elseif ($status == 'C') {
               $txt_status = 'ยกเลิก';
          }
          return $txt_status;
     }

     public function documentPrint(Request $request)
     {
          $picklist_sheet = $request->picklist_sheet;
          $cover_sheet = $request->cover_sheet;
          $invoice_sheet = $request->invoice_sheet;
          $order_ids = explode(",", $request->order_id);
          \DB::beginTransaction();
          try {
               foreach ($order_ids as $key => $order_id) {
                    $order = Order::find($order_id);
                    if ($order->picklist_sheet == 'Y') {
                         $picklist_sheet = 'Y';
                    }
                    if ($order->cover_sheet == 'Y') {
                         $cover_sheet = 'Y';
                    }
                    if ($order->invoice_sheet == 'Y') {
                         $invoice_sheet = 'Y';
                    }
                    $data = [
                         'picklist_sheet' => $picklist_sheet
                         ,'cover_sheet' => $cover_sheet
                         ,'invoice_sheet' => $invoice_sheet
                         ,'picklist_sheet_at' => ($picklist_sheet == 'Y' ? date('Y-m-d H:i:s') : NULL)
                         ,'cover_sheet_at' => ($cover_sheet == 'Y' ? date('Y-m-d H:i:s') : NULL)
                         ,'invoice_sheet_at' => ($invoice_sheet == 'Y' ? date('Y-m-d H:i:s') : NULL)
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                    ];
                    Order::where('id', '=', $order_id)->update($data);
               }
               \DB::commit();

               // if ($picklist_sheet == 'Y') {
               $data["picklist_sheet"] = $picklist_sheet;
               $data["cover_sheet"] = $cover_sheet;
               $data["invoice_sheet"] = $invoice_sheet;
               $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
               $data['orders'] =  Order::whereIn('id', $order_ids)->with(['Currency', 'OrderProduct', 'OrderBoxs', 'Shipping'])->get();
               // }
               $data2 = view('Admin.Order.documentPrint', $data);
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
               $mpdf->Output('QrCode_'. date('Y_m_d') .'.pdf', 'I');
          } catch (\Mpdf\MpdfException $e) {
               \DB::rollBack();
          }
     }

     public function getPrinted($order_id)
     {
          $txt = '';
          $order = Order::find($order_id);
          if ($order->picklist_sheet == 'Y') {
               $txt .= 'Picklist';
          }
          if ($order->cover_sheet == 'Y') {
               $txt .= ','.'ใบปะหน้าพัสดุ';
          }
          if ($order->invoice_sheet == 'Y') {
               $txt .= ','.'ใบแจ้งหนี้';
          }

          return $txt;
     }

     public function adjustStatusToShipping(Request $request)
     {
          $order_no = $request->data;
          $validator = Validator::make($request->all(), [
               "order_no" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $order = Order::where('order_no', '=', $order_no)->first();
                    $data = [
                         'status' => 'T'
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                    ];
                    Order::where('id', '=', $order->id)->update($data);
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
               $return['content'] = '';
          }
          $return['title'] = '';
          return json_encode($return);
     }


}
