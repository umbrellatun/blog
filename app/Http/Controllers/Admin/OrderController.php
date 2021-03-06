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
use App\Models\ShippingOrder;
use App\Models\UserOrder;
use App\Models\BoxStock;
use App\Models\ProductStock;
use App\Models\OrderCount;

use App\User;
use \Mpdf\Mpdf;
use Validator;
use Storage;

use App\Repositories\MenuRepository;
use App\Repositories\UserRepository;

class OrderController extends Controller
{
     public function __construct(MenuRepository $menupos, UserRepository $userpos)
     {
          $this->menupos = $menupos;
          $this->userpos = $userpos;
     }

     public function index(Request $request)
     {
          $data["titie"] = "รายการสั่งซื้อ";
          $data["user"] = $user = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = $this->menupos->getParentMenu();
          $data["shippings"] = Shipping::where('status', 'Y')->get();
          $data["currencies"] = Currency::where('use_flag', 'Y')->get();
          $data["all_orders"] = Order::get();
          $orders = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs', 'Transfer'])->orderBy('created_at', 'desc');
          if ($user->Role->id == 3){
               $orders->where('company_id', '=', $user->company_id);
          }
          if ($request->all()){
               $status = $request->status;
               // if ($status == 'A'){
               //      $orders->where(function($q)use($status){
               //           $q->whereNotNull('status');
               //      });
               // } else {
               //      $orders->where(function($q)use($status){
               //           $q->where('status', '=', $status);
               //      });
               // }
               $orders->where(function($q)use($status){
                    $q->whereNotNull('status');
               });
               $document_status = $request->document_status;
               if ($document_status == 1){
                    $orders->where(function($q)use($document_status){
                         $q->where('picklist_sheet', '!=', 'Y');
                         $q->where('cover_sheet', '!=', 'Y');
                         $q->where('shipping_sheet', '!=', 'Y');
                         $q->where('invoice_sheet', '!=', 'Y');
                    });
               } elseif($document_status == 2) {
                    $orders->where(function($q)use($document_status){
                         $q->where('picklist_sheet', '!=', 'Y');
                         $q->where('cover_sheet', '=', 'Y');
                         $q->where('shipping_sheet', '=', 'Y');
                         $q->where('invoice_sheet', '=', 'Y');
                    });
               } elseif($document_status == 3) {
                    $orders->where(function($q)use($document_status){
                         $q->where('picklist_sheet', '=', 'Y');
                         $q->where('cover_sheet', '!=', 'Y');
                         $q->where('shipping_sheet', '=', 'Y');
                         $q->where('invoice_sheet', '=', 'Y');
                    });
               } elseif($document_status == 4) {
                    $orders->where(function($q)use($document_status){
                         $q->where('picklist_sheet', '=', 'Y');
                         $q->where('cover_sheet', '=', 'Y');
                         $q->where('shipping_sheet', '!=', 'Y');
                         $q->where('invoice_sheet', '=', 'Y');
                    });
               }
          }
          $data["all_orders"] = $orders->get();
          $data["orders"] = $orders->paginate(10)->appends(request()->query());
          // $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->where('status', '=', 'W')->get();
          return view('Admin.Order.list', $data);
     }

     public function create()
     {
          $data["titie"] = "เพิ่มคำสั่งซื้อ";
          $data["user"] = $user = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["users"] = User::with('Role')->get();
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::where('use_flag', 'Y')->get();
          $data["companies"] = Company::where('use_flag', 'Y')->get();
          $data["shippings"] = Shipping::where('status', 'Y')->get();
          $data["customers"] = Customer::get();
          $data["laos_districts"] = LaosDistrict::get();
          $data["products"] = Product::with('ProductType')->where('use_flag', 'Y')->where('company_id', $user->company_id)->get();
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
          // $data["order_no"] = 'PO-' . date('Ymd') . '-' . date('His');
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

     public function getLastOrderNo()
     {
          \DB::beginTransaction();
          try {
               $order_count = OrderCount::where('year', date('Y'))->first();
               if ($order_count){
                    $data = [
                         'count' => $order_count->count+1
                         ,'created_by' => \Auth::guard('admin')->id()
                         ,'created_at' => date('Y-m-d H:i:s')
                    ];
                    OrderCount::where('id', $order_count->id)->update($data);
                    \DB::commit();
                    return 'PO'.$order_count->year.str_pad($order_count->count+1, 4, "0", STR_PAD_LEFT);
               } else {
                    $data = [
                         'year' => date('Y')
                         ,'count' => 1
                         ,'created_by' => \Auth::guard('admin')->id()
                         ,'created_at' => date('Y-m-d H:i:s')
                    ];
                    OrderCount::insert($data);
                    \DB::commit();
                    return 'PO'.date('Y').str_pad(1, 4, "0", STR_PAD_LEFT);
               }
          } catch (\Exception $e) {
               \DB::rollBack();
               $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
          }
     }

     public function store(Request $request)
     {
          // dd($request->all());
          // $order_no = $request->order_no;
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
               'company_id' => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $order_no = self::getLastOrderNo();
                    /* หาค่าธรรมเนียม % COD */
                    $company = Company::find($company_id);
                    $cod = 0;
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
                         }
                    }
                    $cod = $total * ($company->delivery / 100);
                    /* End หาค่าธรรมเนียม % COD */

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
                         if ( $transfer_cod_amount > 0 ){
                              $status = 'P';
                         } else {
                              $status = 'W';
                         }
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
                                   ,'cod_amount' => $transfer_cod_amount
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
                                   ,'cod_amount' => $transfer_cod_amount
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
                    $order = Order::with('Transfer')->find($id);
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
                         $order_transfer_status = [];
                         if (sizeof($order->transfer) > 0){
                              foreach ($order->transfer as $key => $transfer) {
                                   array_push($order_transfer_status, $transfer->status);
                              }
                         }
                         if (in_array('N', $order_transfer_status)){
                              $status = 'W';
                         }else{
                              $status = 'P';
                         }
                         $fileName = '';
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
                              // if ($order_box_id){
                              //      $data = [
                              //           'in_stock' => $box->in_stock - $box_amounts[$i]
                              //      ];
                              //      Box::where('id', '=', $box_ids[$i])->update($data);
                              // }
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

     public function GetBgOrderStatus($status)
     {
          if ($status == 'W') {
               $txt_status = 'badge-light-danger';
          } elseif ($status == 'WA') {
               $txt_status = 'badge-light-danger';
          } elseif ($status == 'P') {
               $txt_status = 'badge-light-warning';
          } elseif ($status == 'FP') {
               $txt_status = 'badge-light-warning';
          } elseif ($status == 'WT') {
               $txt_status = 'badge-light-info';
          } elseif ($status == 'T') {
               $txt_status = 'badge-light-info';
          } elseif ($status == 'S') {
               $txt_status = 'badge-light-success';
          } elseif ($status == 'C') {
               $txt_status = 'badge-light-danger';
          }
          return $txt_status;
     }

     public function documentPrint(Request $request)
     {
          $picklist_sheet = $request->picklist_sheet;
          $cover_sheet = $request->cover_sheet;
          $shipping_sheet = $request->shipping_sheet;
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
                    if ($order->shipping_sheet == 'Y') {
                         $shipping_sheet = 'Y';
                    }
                    if ($order->invoice_sheet == 'Y') {
                         $invoice_sheet = 'Y';
                    }
                    $data = [
                         'picklist_sheet' => $picklist_sheet
                         ,'cover_sheet' => $cover_sheet
                         ,'shipping_sheet' => $shipping_sheet
                         ,'invoice_sheet' => $invoice_sheet
                         ,'picklist_sheet_at' => ($picklist_sheet == 'Y' ? date('Y-m-d H:i:s') : NULL)
                         ,'cover_sheet_at' => ($cover_sheet == 'Y' ? date('Y-m-d H:i:s') : NULL)
                         ,'shipping_sheet_at' => ($shipping_sheet == 'Y' ? date('Y-m-d H:i:s') : NULL)
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
               $data["shipping_sheet"] = $shipping_sheet;
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
               $txt .= '<span class="badge badge-light-info badge-pill mr-1 mb-1">Picklist</span>';
          }
          if ($order->cover_sheet == 'Y') {
               $txt .= '<span class="badge badge-light-info badge-pill mb-1">ใบปะหน้าพัสดุ</span>';
          }
          if ($order->shipping_sheet == 'Y') {
               $txt .= '<br/><span class="badge badge-light-info badge-pill mr-1 mb-1">ใบสำหรับเจ้าหน้าที่ขนส่ง</span>';
          }
          if ($order->invoice_sheet == 'Y') {
               $txt .= '<span class="badge badge-light-info badge-pill mb-1">ใบแจ้งหนี้</span>';
          }
          if ($order->picklist_sheet != 'Y' and $order->cover_sheet != 'Y' and $order->shipping_sheet != 'Y' and $order->invoice_sheet != 'Y') {
               $txt .= '<span class="badge badge-light-danger badge-pill mb-1">ยังไม่พิมพ์เอกสารใดๆ</span>';
          }
          return $txt;
     }

     public function adjustStatusToShipping(Request $request)
     {
          $order_no = $request->data;
          $validator = Validator::make($request->all(), [
               "data" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $order = Order::where('order_no', '=', $order_no)->first();
                    $shipping_orders = ShippingOrder::where('order_id', '=', $order->id)->get();
                    if (sizeof($shipping_orders) > 0) {
                         $return['status'] = 0;
                         $return['content'] = 'มีออเดอร์นี้อยู่ในสถานะกำลังจัดส่งแล้ว';
                    } else {
                         $data = [
                              'status' => 'T'
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $order->id)->update($data);

                         $data = [
                              'shipping_id' => $order->shipping_id
                              ,'order_id' => $order->id
                              ,'status' => 'S'
                              ,'created_by' => \Auth::guard('admin')->id()
                              ,'created_at' => date('Y-m-d H:i:s')
                         ];
                         ShippingOrder::insert($data);
                         \DB::commit();
                         $return['status'] = 1;
                         $return['order_id'] = $order->id;
                         $return['content'] = 'จัดเก็บสำเร็จ';
                    }

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

     public function adjustStatusSuccessShipping(Request $request)
     {
          // dd($request->all());
          // $receive_moneys = $request->receive_money;
          $receive_money_thbs = $request->receive_money_thb;
          $receive_money_laks = $request->receive_money_lak;
          $real_shipping_cost_thbs = $request->real_shipping_cost_thb;
          $real_shipping_cost_laks = $request->real_shipping_cost_lak;
          $remarks = $request->remark;
          // $receive_currency_ids = $request->receive_currency_id;
          $validator = Validator::make($request->all(), [
               "receive_money_thb" => 'required',
               "receive_money_lak" => 'required',
               "real_shipping_cost_thb" => 'required',
               "real_shipping_cost_lak" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $order_arr = [];
                    foreach ($receive_money_thbs as $order_id => $receive_money_thb) {
                         if (!isset($receive_money_thb)) {
                              $return['status'] = 0;
                              $return['content'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
                              return json_encode($return);
                         } else {
                              $data = [
                                   "status" => 'S'
                                   ,"receive_money_thb" => $receive_money_thb
                                   ,"receive_money_lak" => $receive_money_laks[$order_id]
                                   ,"real_shipping_cost_thb" => $real_shipping_cost_thbs[$order_id]
                                   ,"real_shipping_cost_lak" => $real_shipping_cost_laks[$order_id]
                                   // ,"receive_money" => $receive_money
                                   // ,"receive_currency_id" => $receive_currency_ids[$order_id]
                                   ,"remark" => $remarks[$order_id]
                                   ,"received_at" => date('Y-m-d H:i:s')
                                   ,"received_by" => \Auth::guard('admin')->id()
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              Order::where('id', $order_id)->update($data);

                              $data = [
                                   'user_id' => \Auth::guard('admin')->id()
                                   ,'order_id' => $order_id
                                   // ,'amount' => $receive_money
                                   // ,'currency_id' => $receive_currency_ids[$order_id]
                                   ,'receive_money_thb' => $receive_money_thb
                                   ,'receive_money_lak' => $receive_money_laks[$order_id]
                                   ,"real_shipping_cost_thb" => $real_shipping_cost_thbs[$order_id]
                                   ,"real_shipping_cost_lak" => $real_shipping_cost_laks[$order_id]
                                   ,'status' => 'S'
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              UserOrder::insert($data);

                              $data = [
                                   'status' => 'T'
                                   ,"real_shipping_cost_thb" => $real_shipping_cost_thbs[$order_id]
                                   ,"real_shipping_cost_lak" => $real_shipping_cost_laks[$order_id]
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              ShippingOrder::where('order_id', '=', $order_id)->update($data);
                         }
                         array_push($order_arr, $order_id);
                    }
                    // foreach ($order_ids as $order_id) {
                    //      $order = Order::with(['OrderBoxs', 'OrderProduct'])->find($order_id);
                    //
                    //      $sum_product_bath = 0;
                    //      $sum_product_lak = 0;
                    //      $sum_product_usd = 0;
                    //      $sum_product_khr = 0;
                    //
                    //      $sum_box_bath = 0;
                    //      $sum_box_lak = 0;
                    //      $sum_box_usd = 0;
                    //      $sum_box_khr = 0;
                    //      foreach ($order->OrderProduct as $order_product){
                    //           $sum_product_bath += $order_product->price_bath;
                    //           $sum_product_lak += $order_product->price_lak;
                    //           $sum_product_usd += $order_product->price_usd;
                    //           $sum_product_khr += $order_product->price_khr;
                    //      }
                    //
                    //      foreach ($order->OrderBoxs as $order_box) {
                    //           $sum_box_bath += $order_box->price_bath;
                    //           $sum_box_lak += $order_box->price_lak;
                    //           $sum_box_usd += $order_box->price_usd;
                    //           $sum_box_khr += $order_box->price_khr;
                    //      }
                    //
                    //      if ($currency_id == 1){
                    //           $receive_money = $sum_product_bath + $sum_box_bath;
                    //      } elseif($currency_id == 2) {
                    //           $receive_money = $sum_product_lak + $sum_box_lak;
                    //      } elseif($currency_id == 3) {
                    //           $receive_money = $sum_product_usd + $sum_box_usd;
                    //      } elseif($currency_id == 4) {
                    //           $receive_money = $sum_product_khr + $sum_box_khr;
                    //      }
                    //
                    //      $data = [
                    //           'user_id' => \Auth::guard('admin')->id()
                    //           ,'order_id' => $order_id
                    //           ,'amount' => $receive_money
                    //           ,'currency_id' => $currency_id
                    //           ,'status' => 'S'
                    //           ,'created_by' => \Auth::guard('admin')->id()
                    //           ,'created_at' => date('Y-m-d H:i:s')
                    //      ];
                    //      UserOrder::insert($data);
                    //
                    //      $data = [
                    //           'status' => 'T'
                    //           ,'updated_by' => \Auth::guard('admin')->id()
                    //           ,'updated_at' => date('Y-m-d H:i:s')
                    //      ];
                    //      ShippingOrder::where('order_id', '=', $order_id)->update($data);
                    //
                    //      $data = [
                    //           'status' => 'S'
                    //           ,'updated_by' => \Auth::guard('admin')->id()
                    //           ,'updated_at' => date('Y-m-d H:i:s')
                    //      ];
                    //      Order::where('id', '=', $order_id)->update($data);
                    // }
                    \DB::commit();
                    $return['status'] = 1;
                    $return['order_arr'] = $order_arr;
                    $return['content'] = 'จัดเก็บสำเร็จ';
               } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
               $return['content'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
          }
          $return['title'] = '';
          return json_encode($return);
     }

     public function getTranfersView(Request $request)
     {
          $order_id = $request->order_id;
          $validator = Validator::make($request->all(), [
               "order_id" => 'required',
          ]);
          if (!$validator->fails()) {
               try {
                    $transfers = Transfer::with(['User', 'Currency'])->where('order_id', $order_id)->get();
                    $return['status'] = 1;
                    $return['transfers'] = $transfers;
               } catch (Exception $e) {
                    $return['status'] = 0;
               }
          } else{
               $return['status'] = 0;
          }
          return json_encode($return);
     }

     public function SaveTranfersView(Request $request)
     {
          $transfer_ids = $request->data;
          $order_id = $request->order_id;
          $validator = Validator::make($request->all(), [
               "data" => 'required',
               "order_id" => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    foreach ($transfer_ids as $key => $transfer_id) {
                         $data = [
                              'status' => 'Y'
                              ,'payee_id' => \Auth::guard('admin')->id()
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];

                         Transfer::where('id', '=', $transfer_id)->update($data);
                    }

                    $status_arr = [];
                    $transfers = Transfer::where('order_id', '=', $order_id)->get();
                    foreach ($transfers as $transfer) {
                         array_push($status_arr, $transfer->status);
                    }
                    $remove_order = 0;
                    if(!in_array('W', $status_arr)){
                         $data = [
                              'status' => 'P'
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $order_id)->update($data);
                         $remove_order = 1;
                    }

                    \DB::commit();
                    $return['status'] = 1;
                    $return['remove_order'] = $remove_order;
                    $return['content'] = "สำเร็จ";
               } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
          }
          return json_encode($return);

     }

     public function openReceiveMoneyModal(Request $request)
     {
          $order_id = $request->order_id;
          try {
               $order = Order::find($order_id);
               return $order;
          } catch (\Exception $e) {
               return null;
          }

     }

     public function ReceiveMoneyOrder(Request $request)
     {
          $receive_money_thb = $request->receive_money_thb;
          $receive_money_lak = $request->receive_money_lak;
          $adjust_success_order_id_hdn = $request->adjust_success_order_id_hdn;
          // $currency_id = $request->currency_id;
          $remark = $request->remark;
          $validator = Validator::make($request->all(), [
               "receive_money_thb" => 'required',
               "receive_money_lak" => 'required',
               "adjust_success_order_id_hdn" => 'required',
               // "currency_id" => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $data = [
                         'user_id' => \Auth::guard('admin')->id()
                         ,'order_id' => $adjust_success_order_id_hdn
                         ,'receive_money_thb' => $receive_money_thb
                         ,'receive_money_lak' => $receive_money_lak
                         ,'status' => 'S'
                         ,'created_by' => \Auth::guard('admin')->id()
                         ,'created_at' => date('Y-m-d H:i:s')
                    ];
                    UserOrder::insert($data);

                    $data = [
                         'status' => 'T'
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                    ];
                    ShippingOrder::where('order_id', '=', $adjust_success_order_id_hdn)->update($data);

                    $data = [
                         "status" => 'S'
                         ,"receive_money_thb" => $receive_money_thb
                         ,"receive_money_lak" => $receive_money_lak
                         ,"remark" => $remark
                         ,"received_at" => date('Y-m-d H:i:s')
                         ,"received_by" => \Auth::guard('admin')->id()
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                    ];
                    Order::where('id', '=', $adjust_success_order_id_hdn)->update($data);

                    \DB::commit();
                    $return['status'] = 1;
                    $return['order_id'] = $adjust_success_order_id_hdn;
                    $return['content'] = "บันทึกข้อมูลสำเร็จ";
               } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function openPackingModal (Request $request)
     {
          $order_id = $request->order_id;
          try {
               $order = Order::with('OrderProduct.Product', 'OrderBoxs.Box')->find($order_id);
               return $order;
          } catch (\Exception $e) {
               return null;
          }
     }

     public function getOrderToAdjustStatus(Request $request)
     {
          $data = $request->data;
          $validator = Validator::make($request->all(), [
               "data" => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $order = Order::with(['OrderProduct', 'OrderBoxs', 'Currency'])->where('order_no', $data)->first();
                    $currencies = Currency::where('use_flag', 'Y')->get();
                    if ($order and $currencies){
                         $return["order"] = $order;
                         $return["currencies"] = $currencies;
                         $return['status'] = 1;
                    }
                    else {
                         $return['content'] = "ไม่พบข้อมูล";
                    }
               }catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function SumOrderPrice($order_id)
     {
          try {
               $order = Order::with(['OrderProduct', 'OrderBoxs'])->find($order_id);
               $shipping = $order->shipping_cost;
               $discount = $order->discount;
               if ($order->currency_id == 1) {
                    $sum_product_price = $order->OrderProduct->sum('price_bath');
                    $sum_box_price = $order->OrderBoxs->sum('price_bath');
               }
               if ($order->currency_id == 2) {
                    $sum_product_price = $order->OrderProduct->sum('price_lak');
                    $sum_box_price = $order->OrderBoxs->sum('price_lak');
               }
               return number_format(($sum_product_price + $sum_box_price + $shipping) - $discount, 2);
          } catch (\Exception $e) {
               return null;
          }
     }

     public function getOrderType($order_id)
     {
          try {
               $txt = '';
               $order = Order::with(['Transfer', 'Currency'])->find($order_id);
               $select_currency = true;
               if (sizeof($order->Transfer) > 0 ) {
                    $thb = 0;
                    $lak = 0;
                    $thb_not_approve = 0;
                    $lak_not_approve = 0;
                    foreach ($order->Transfer as $key => $transfer) {
                         if ($transfer->status == 'Y') {
                              if ($transfer->currency_id == 1){
                                   $thb = $thb + $transfer->amount;
                                   $txt .= '<span class="badge badge-light-success badge-pill mr-1 mb-1">โอนแล้ว : '. number_format($thb, 2).'THB</span><br/>';
                              }
                              if ($transfer->currency_id == 2){
                                   $lak = $lak + $transfer->amount;
                                   $txt .= '<span class="badge badge-light-warning badge-pill mr-1 mb-1">โอนแล้ว : '. number_format($lak, 2).'LAK</span><br/>';
                              }
                              if (empty($transfer->currency_id)){
                                   $select_currency = false;
                              }
                         } else {
                              if ($transfer->currency_id == 1){
                                   $thb_not_approve = $thb_not_approve + $transfer->amount;
                                   $txt .= '<span class="badge badge-light-success badge-pill mr-1 mb-1">รอตรวจสอบ : '.number_format($thb_not_approve, 2).'THB</span><br/>';
                              }
                              if ($transfer->currency_id == 2){
                                   $lak_not_approve = $lak_not_approve + $transfer->amount;
                                   $txt .= '<span class="badge badge-light-warning badge-pill mr-1 mb-1">รอตรวจสอบ : '.number_format($lak_not_approve, 2).'LAK</span><br/>';
                              }
                              if (empty($transfer->currency_id)){
                                   $select_currency = false;
                              }
                         }
                    }
               }
               if ($order->cod_amount > 0){
                    $txt .= '<h6 class="mr-1 mb-1">ยอดเรียกเก็บ(COD) : '.number_format($order->cod_amount, 2).$order->Currency->name.'</h6>';
                    // $txt .= '<span class="h5 badge-light-info mr-1 mb-1">เก็บเงินปลายทาง : '.$order->cod_amount.$order->Currency->name.'</span>';
               }
               if (!$select_currency){
                    $txt .= '<span class="badge badge-light-danger badge-pill mr-1 mb-1">สลิปที่แนบมายังไม่เลือกสกุลเงิน</span><br/>';
               }
               return $txt;

          } catch (\Exception $e) {
               return null;
          }

     }

     public function getOrderCOD($order_id)
     {
          try {
               $txt = '';
               $order = Order::with(['Transfer', 'Currency'])->find($order_id);
               if ($order->cod_amount > 0){
                    $txt .= '<span class="badge badge-light-info badge-pill mr-1 mb-1">เก็บเงินปลายทาง : '. number_format($order->cod_amount, 2) .$order->Currency->name.'</span>';
               }
               return $txt;

          } catch (\Exception $e) {
               return null;
          }

     }

     public function cancel(Request $request)
     {
          $order_id = $request->order_id;
          $validator = Validator::make($request->all(), [
               "order_id" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $order = Order::with(['OrderBoxs', 'OrderProduct'])->find($order_id);
                    foreach ($order->OrderProduct as $key => $product) {
                         $order_product_id = $product->id;
                         if ($product->status == 'S'){
                              $data = [
                                   'status' => 'C'
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              OrderProduct::where('id', $order_product_id)->update($data);

                              $product_id = $product->product_id;
                              $get_product = Product::find($product_id);
                              $data = [
                                   'in_stock' => $get_product->in_stock + 1
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              Product::where('id', $product_id)->update($data);

                              $data = [
                                   'product_id' => $product_id
                                   ,'plus' => 1
                                   ,'delete' => 0
                                   ,'stock' => $get_product->in_stock + 1
                                   ,'remark' => 'ยกเลิก Order : ' . $order->order_no
                                   ,'order_id' => $order->id
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              ProductStock::insert($data);
                         }
                    }
                    foreach ($order->OrderBoxs as $key => $box) {
                         if ($box->status == 'S'){
                              $order_box_id = $box->id;
                              $data = [
                                   'status' => 'C'
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              OrderBoxs::where('id', $order_box_id)->update($data);

                              $box_id = $box->box_id;
                              $get_box = Box::find($box_id);
                              $data = [
                                   'in_stock' => $get_box->in_stock + 1
                                   ,'updated_by' => \Auth::guard('admin')->id()
                                   ,'updated_at' => date('Y-m-d H:i:s')
                              ];
                              Box::where('id', $get_box->id)->update($data);

                              $data = [
                                   'box_id' => $box_id
                                   ,'plus' => 1
                                   ,'delete' => 0
                                   ,'stock' => $get_box->in_stock + 1
                                   ,'remark' => 'ยกเลิก Order : ' . $order->order_no
                                   ,'order_id' => $order->id
                                   ,'created_by' => \Auth::guard('admin')->id()
                                   ,'created_at' => date('Y-m-d H:i:s')
                              ];
                              BoxStock::insert($data);
                         }
                    }
                    $data = [
                         'status' => 'C'
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                         ,'cancel_by' => \Auth::guard('admin')->id()
                         ,'cancel_at' => date('Y-m-d H:i:s')
                    ];
                    Order::where('id', $order_id)->update($data);

                    \DB::commit();
                    $return['status'] = 1;
                    $return['order'] = $order_id;
                    $return['content'] = "ยกเลิกออเดอร์สำเร็จ";
               } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function documentPrintCoverSheet(Request $request)
     {
          $order_arr = [];
          $order_ids = explode(",", $request->order_id);
          \DB::beginTransaction();
          try {
               foreach ($order_ids as $key => $order_id) {
                    $order = Order::find($order_id);
                    $data = [
                         'cover_sheet' => 'Y'
                         ,'cover_sheet_at' => date('Y-m-d H:i:s')
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                    ];
                    Order::where('id', '=', $order_id)->update($data);
               }
               \DB::commit();

               $data["cover_sheet"] = 'Y';
               $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
               $data['orders'] =  Order::whereIn('id', $order_ids)->with(['Currency', 'OrderProduct', 'OrderBoxs', 'Shipping'])->get();
               // }
               $data2 = view('Admin.OrderPDF.coverSheet', $data);
               $mpdf = new Mpdf([
                    'autoLangToFont' => true,
                    'mode' => 'utf-8',
                    'format' => [100.0, 180.0],
                    'margin_top' => 1,
                    'margin_left' => 1,
                    'margin_right' => 1,
                    'margin_bottom' => 1,
               ]);
               // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
               $mpdf->WriteHTML($data2);
               $mpdf->Output('QrCode_'. date('Y_m_d') .'.pdf', 'I');
          } catch (\Mpdf\MpdfException $e) {
               \DB::rollBack();
          }
     }

     public function PDFPrintCoverSheet(Request $request)
     {
          $order_ids = explode(",", $request->order_ids);
          $validator = Validator::make($request->all(), [
               "order_ids" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    foreach ($order_ids as $key => $order_id) {
                         $order = Order::find($order_id);
                         $data = [
                              'cover_sheet' => 'Y'
                              ,'cover_sheet_at' => date('Y-m-d H:i:s')
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $order_id)->update($data);
                    }
                    \DB::commit();
                    $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
                    $data['orders'] =  Order::whereIn('id', $order_ids)->with(['Currency', 'OrderProduct', 'OrderBoxs', 'Shipping'])->get();
                    $data2 = view('Admin.OrderPDF.coverSheet', $data);
                    $mpdf = new Mpdf([
                         'autoLangToFont' => true,
                         'mode' => 'utf-8',
                         'format' => [100.0, 180.0],
                         'margin_top' => 1,
                         'margin_left' => 1,
                         'margin_right' => 1,
                         'margin_bottom' => 1,
                    ]);
                    // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
                    $mpdf->WriteHTML($data2);
                    $mpdf->Output('QrCode_'. date('Y_m_d') .'.pdf', 'I');
               } catch (\Mpdf\MpdfException $e) {
                    \DB::rollBack();
                    $return['status'] = "0";
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else {
               $return['status'] = "0";
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function PDFPrintPickList(Request $request)
     {
          $order_ids = explode(",", $request->order_ids);
          $validator = Validator::make($request->all(), [
               "order_ids" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    foreach ($order_ids as $key => $order_id) {
                         $order = Order::find($order_id);
                         $data = [
                              'picklist_sheet' => 'Y'
                              ,'picklist_sheet_at' => date('Y-m-d H:i:s')
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $order_id)->update($data);
                    }
                    \DB::commit();
                    $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
                    $data['orders'] =  Order::whereIn('id', $order_ids)->with(['Currency', 'OrderProduct', 'OrderBoxs', 'Shipping'])->get();
                    $data2 = view('Admin.OrderPDF.picklistSheet', $data);
                    $mpdf = new Mpdf([
                         'autoLangToFont' => true,
                         'mode' => 'utf-8',
                         'format' => 'A4',
                         'margin_top' => 1,
                         'margin_left' => 1,
                         'margin_right' => 1,
                         'margin_bottom' => 1,
                    ]);
                    // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
                    $mpdf->WriteHTML($data2);
                    $mpdf->Output('Picklist_'. date('Y_m_d') .'.pdf', 'I');
               } catch (\Mpdf\MpdfException $e) {
                    \DB::rollBack();
                    $return['status'] = "0";
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else {
               $return['status'] = "0";
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function PDFPrintInvoice(Request $request)
     {
          $order_ids = explode(",", $request->order_ids);
          $validator = Validator::make($request->all(), [
               "order_ids" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    foreach ($order_ids as $key => $order_id) {
                         $order = Order::find($order_id);
                         $data = [
                              'invoice_sheet' => 'Y'
                              ,'invoice_sheet_at' => date('Y-m-d H:i:s')
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $order_id)->update($data);
                    }
                    \DB::commit();
                    $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
                    $data['orders'] =  Order::whereIn('id', $order_ids)->with(['Currency', 'OrderProduct', 'OrderBoxs', 'Shipping'])->get();
                    $data2 = view('Admin.OrderPDF.invoiceSheet', $data);
                    $mpdf = new Mpdf([
                         'autoLangToFont' => true,
                         'mode' => 'utf-8',
                         'format' => 'A4',
                         'margin_top' => 1,
                         'margin_left' => 1,
                         'margin_right' => 1,
                         'margin_bottom' => 1,
                    ]);
                    // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
                    $mpdf->WriteHTML($data2);
                    $mpdf->Output('Picklist_'. date('Y_m_d') .'.pdf', 'I');
               } catch (\Mpdf\MpdfException $e) {
                    \DB::rollBack();
                    $return['status'] = "0";
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else {
               $return['status'] = "0";
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function PDFPrintShippingSheet(Request $request)
     {
          $order_ids = explode(",", $request->order_ids);
          $validator = Validator::make($request->all(), [
               "order_ids" => 'required',
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    foreach ($order_ids as $key => $order_id) {
                         $order = Order::find($order_id);
                         $data = [
                              'shipping_sheet' => 'Y'
                              ,'shipping_sheet_at' => date('Y-m-d H:i:s')
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Order::where('id', '=', $order_id)->update($data);
                    }
                    \DB::commit();
                    $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
                    $data['orders'] =  Order::whereIn('id', $order_ids)->with(['Currency', 'OrderProduct', 'OrderBoxs', 'Shipping'])->get();
                    $data2 = view('Admin.OrderPDF.shippingSheet', $data);
                    $mpdf = new Mpdf([
                         'autoLangToFont' => true,
                         'mode' => 'utf-8',
                         'format' => 'A4',
                         'margin_top' => 1,
                         'margin_left' => 1,
                         'margin_right' => 1,
                         'margin_bottom' => 1,
                    ]);
                    // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
                    $mpdf->WriteHTML($data2);
                    $mpdf->Output('Picklist_'. date('Y_m_d') .'.pdf', 'I');
               } catch (\Mpdf\MpdfException $e) {
                    \DB::rollBack();
                    $return['status'] = "0";
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else {
               $return['status'] = "0";
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function info(Request $request)
     {
          $order_id = $request->order_id;
          $validator = Validator::make($request->all(), [
               "order_id" => 'required',
          ]);
          if (!$validator->fails()) {
               try {
                    $order = Order::with('OrderBoxs.Box')
                    ->with('OrderProduct.Product')
                    ->with('Currency')
                    ->with('Shipping')
                    ->with('Company')
                    ->with('LaosDistrict')
                    ->with('Transfer')
                    ->find($order_id);
                    $html = '';
                    $html .= '<div class="card-body">';
                    $html .= '<div class="row invoive-info">';
                    $html .= '<div class="col-md-4 col-xs-12 invoice-client-info">';
                    $html .= '<h6>ข้อมูลผู้ซื้อ :</h6>';
                    $html .= '<h6 class="m-0">'.$order->customer_name.'</h6>';
                    $html .= '<p class="m-0 m-t-10">'.$order->customer_address. " " . $order->customer_city . '</p>';
                    $html .= '<p class="m-0 m-t-10">'.$order->LaosDistrict->name. '</p>';
                    $html .= '<p class="m-0">'.$order->customer_phone_number.'</p>';
                    $html .= '</div>';
                    $html .= '<div class="col-md-4 col-sm-6">';
                    $html .= '<h6>รายละเอียดออเดอร์ :</h6>';
                    $html .= '<p class="m-0 m-t-10">วันที่สร้าง : '.$order->created_at . '</p>';
                    $html .= '<p class="m-0 m-t-10">ร้านค้า : '.$order->Company->name.'</p>';
                    $html .= '<p class="m-0 m-t-10">สถานะ : <span class="badge '.self::GetBgOrderStatus($order->status).'">'.self::GetOrderStatus($order->status).'</span></p>';

                    if (count($order->Transfer) > 0) {
                         $order_type_transfer = '<span class="badge badge-primary mr-2">โอนชำระค่าสินค้า</span>';
                    } else {
                         $order_type_transfer = '';
                    }

                    if (strlen($order->cod_amount) > 0) {
                         $order_type_cod = '<span class="badge badge-info">เก็บเงินปลายทาง</span>';
                    } else {
                         $order_type_cod = '';
                    }
                    $html .= '<p class="m-0">ประเภท : '.$order_type_transfer.$order_type_cod.'</p>';
                    $html .= '</div>';
                    $html .= '<div class="col-md-4 col-sm-6">';
                    $html .= '<h6 class="m-b-20">Order NO.<br/><span class="text-primary">'.$order->order_no.'</span></h6>';
                    $html .= '<p class="m-0 m-t-10">การจัดส่ง : '.$order->Shipping->name . '</p>';
                    if ($order->currency_id == 1) {
                         $order_price = $order->OrderProduct->sum('price_bath');
                         $box_price = $order->OrderBoxs->sum('price_bath');
                    } else {
                         $order_price = $order->OrderProduct->sum('price_lak');
                         $box_price = $order->OrderBoxs->sum('price_lak');
                    }
                    $html .= '<p class="m-0 m-t-10">ค่าสินค้า : '.number_format($order_price)." ".$order->Currency->name_th.'</p>';
                    $html .= '<p class="m-0 m-t-10">ค่ากล่อง : '.number_format($box_price)." ".$order->Currency->name_th.'</p>';
                    $html .= '<p class="m-0 m-t-10">ส่วนลด : '.number_format($order->discount)." ".$order->Currency->name_th.'</p>';
                    $html .= '<p class="m-0 m-t-10">ค่าจัดส่ง : ' . number_format($order->shipping_cost) . " " . $order->Currency->name_th.'</p>';
                    // $html .= '<h6 class="text-uppercase text-primary">Total Due :';
                    // $html .= '<span>$950.00</span>';
                    // $html .= '</h6>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                    $html .= '<div class="col-sm-12">';
                    $html .= '<div class="table-responsive">';
                    $html .= '<table class="table invoice-detail-table">';
                    $html .= '<thead>';
                    $html .= '<tr class="thead-default">';
                    $html .= '<th>ชื่อสินค้า</th>';
                    $html .= '<th class="text-right">จำนวน</th>';
                    $html .= '<th class="text-right">ราคาต่อชิ้น</th>';
                    $html .= '<th class="text-right">รวม</th>';
                    $html .= '</tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                    foreach ($order->OrderProduct as $key => $OrderProduct) {
                         $html .= '<tr>';
                         $html .= '<td>';
                         $html .= '<h6>'.$OrderProduct->Product->name.'</h6>';
                         // $html .= '<p class="m-0">lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt </p>';
                         $html .= '</td>';
                         // $html .= '<td class="text-right">'.$OrderProduct->pieces.'</td>';
                         $html .= '<td class="text-right">1</td>';
                         if ($order->currency_id == 1) {
                              $amount = $OrderProduct->price_bath;
                         } else {
                              $amount = $OrderProduct->price_lak;
                         }
                         $html .= '<td class="text-right">'.number_format($amount).'</td>';
                         $html .= '<td class="text-right">'.number_format($amount * 1).'</td>';
                         $html .= '</tr>';
                    }
                    foreach ($order->OrderBoxs as $key => $OrderBoxs) {
                         $html .= '<tr>';
                         $html .= '<td>';
                         $html .= '<h6>'.$OrderBoxs->Box->size.'</h6>';
                         $html .= '<p class="m-0">'.$OrderBoxs->Box->description.'</p>';
                         $html .= '</td>';
                         $html .= '<td class="text-right">'.$OrderBoxs->pieces.'</td>';
                         if ($order->currency_id == 1) {
                              $amount = $OrderBoxs->price_bath;
                         } else {
                              $amount = $OrderBoxs->price_lak;
                         }
                         $html .= '<td class="text-right">'.number_format($amount).'</td>';
                         $html .= '<td class="text-right">'.number_format($amount * $OrderBoxs->pieces).'</td>';
                         $html .= '</tr>';
                    }

                    $html .= '</tbody>';
                    $html .= '</table>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="row">';
                    $html .= '<div class="col-sm-12">';
                    $html .= '<table class="table table-responsive invoice-table invoice-total">';
                    $html .= '<tbody>';
                    $html .= '<tr>';
                    $html .= '<th>รวมค่าสินค้า :</th>';
                    $html .= '<td>'. number_format($order_price + $box_price) .'</td>';
                    $html .= '</tr>';
                    $html .= '<tr>';
                    $html .= '<th>ค่าจัดส่ง :</th>';
                    $html .= '<td>'.number_format($order->shipping_cost).'</td>';
                    $html .= '</tr>';
                    $html .= '<tr>';
                    $html .= '<th>ส่วนลด :</th>';
                    $html .= '<td>'.number_format($order->discount).'</td>';
                    $html .= '</tr>';
                    $html .= '<tr class="text-info">';
                    $html .= '<td>';
                    $html .= '<hr>';
                    $html .= '<h5 class="text-primary m-r-10">เป็นเงินทั้งสิ้น :</h5>';
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= '<hr>';
                    $html .= '<h5 class="text-primary">'. number_format(($order_price + $box_price + $order->shipping_cost) - $order->discount) .'</h5>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</tbody>';
                    $html .= '</table>';
                    $html .= '</div>';
                    $html .= '</div>';
                    // $html .= '<div class="row">';
                    // $html .= '<div class="col-sm-12">';
                    // $html .= '<h6>Terms and Condition :</h6>';
                    // $html .= '<p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco';
                    // $html .= '</p>';
                    // $html .= '</div>';
                    // $html .= '</div>';
                    $html .= '</div>';

                    $return['status'] = "1";
                    $return['html'] = $html;
               } catch (\Mpdf\MpdfException $e) {
                    $return['status'] = "0";
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else {
               $return['status'] = "0";
               $return['content'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
          }
          return json_encode($return);
     }

     public function getOrderAction($order_id, $order_no, $order_status, $sizeof_order_transfer)
     {
          try {
               $html = '<div class="overlay-edit text-center" style="opacity: 1; background: none;">';
               $html .= '<button class="btn btn-info btn-get-info" data-value="'.$order_id.'" data-toggle="tooltip" title="ดูข้อมูล" href="">';
               $html .= '<i class="fa fa-info-circle" aria-hidden="true"></i>';
               $html .= '</button>';
               // $html .= '<a class="btn btn-warning btn-edit text-white" data-toggle="tooltip" title="แก้ไขรายการสั่งซื้อ" href="'.route('order.edit', ['id' => $order->id]).'">';
               // $html .= '<i class="ace-icon feather icon-edit-1 bigger-120"></i>';
               // $html .= '</a>';
               if ($order_status != 'FP' and $order_status != 'WT' and $order_status != 'T' and $order_status != 'S' and $order_status != 'C'){
                    $html .= '<a class="btn btn-primary btn-success packing_btn text-white" data-value="'.$order_no.'" data-id="'.$order_id.'" data-toggle="tooltip" title="แพ็คสินค้า">';
                    $html .= '<i class="fas fa-box-open"></i>';
                    $html .= '</a>';
                    $html .= '<a class="btn btn-warning text-white" data-toggle="tooltip" title="ใบแพ็คสินค้า" href="'.route('order.coverSheet', ['id' => $order_id]).'" target="_blank">';
                    $html .= '<i class="fas fa-print"></i>';
                    $html .= '</a>';
               }


               if ($sizeof_order_transfer > 0){
                    $html .= '<a href="#" class="btn waves-effect waves-light btn-info view-transfer-slip-btn" data-id="'.$order_id.'" data-toggle="tooltip" title="ดูหลักฐานการโอนทั้งหมด">';
                    $html .= '<i class="fa fa-eye"></i>';
                    $html .= '</a>';
               }
               $html .= '<a class="btn btn-danger text-white btn-cancel-order" data-id="'.$order_id.'" data-toggle="tooltip" title="ยกเลิกออเดอร์">';
               $html .= '<i class="fa fa-times" aria-hidden="true"></i>';
               $html .= '</a>';
               $html .= '</div>';

               return $html;
          } catch (\Exception $e) {
               return null;
          }
     }

}
