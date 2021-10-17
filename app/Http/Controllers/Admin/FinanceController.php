<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Currency;
use App\Models\Transfer;
use App\Models\Company;
use App\Models\Order;
use App\Models\UserOrderTransfer;
use App\Models\UserOrderTransferDetail;
use App\Models\UserOrder;
use App\Models\PartnerOrder;
use App\Models\PartnerOrderTransfer;
use App\Models\PartnerOrderTransferDetail;
use App\User;
use Validator;
use Storage;
use App\Repositories\MenuRepository;

class FinanceController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index(Request $request)
     {
          if ($request->daterange) {
               $daterange = $request->daterange;
               $docuno = $request->docuno;
               $str_date = explode('-', $daterange);
               $start_date = self::ConvertDate($str_date[0]);
               $end_date = self::ConvertDate($str_date[1]);
               $data["daterange"] = date_format(date_create($start_date), "d M Y") . ' - ' . date_format(date_create($end_date), "d M Y");

          } else {
               if($request->daterange == null){
                    $end_date = date("Ymd");
                    $start_date = date('Ymd',strtotime($end_date . "-15 days"));
                    $data["daterange"] = date_format(date_create($start_date), "d M Y") . ' - ' . date_format(date_create($end_date), "d M Y");
               }
          }
          $start_date = date_create($start_date);
          $start_date = date_format($start_date,"Y-m-d H:i:s");
          $end_date = date_create($end_date);
          $end_date = date_format($end_date,"Y-m-d 23:59:59");
          $data["titie"] = "การเงิน";
          $data["user"] = $user = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::where('use_flag', 'Y')->get();
          $data["user_order_transfers"] = UserOrderTransfer::with('User')->get();
          $company_id = $user->company_id;
          if ($user->role_id == 1) {
               $companies = Company::with(['Order' => function($q) use ($start_date, $end_date){
                    $q->where("created_at", ">=", $start_date);
                    $q->where("created_at", "<=", $end_date);
                    $q->with(['UserOrder' => function($query_user){
                         $query_user->where('status', '=', 'T');
                         $query_user->with('TransferBy');
                    }]);
                    $q->with(['Transfer' => function ($query_transfer){
                         $query_transfer->where('status' ,'=', 'Y');
                    }]);
               }])->get();
          } else if ($user->role_id == 2) {

          } else if ($user->role_id == 3) {
               $companies = Company::with(['Order' => function($q) use ($start_date, $end_date){
                    $q->where("created_at", ">=", $start_date);
                    $q->where("created_at", "<=", $end_date);
                    $q->with(['UserOrder' => function($query_user){
                         $query_user->where('status', '=', 'T');
                         $query_user->with('TransferBy');
                    }]);
                    $q->with(['Transfer' => function ($query_transfer){
                         $query_transfer->where('status' ,'=', 'Y');
                         $query_transfer->with('User');
                    }]);
               }])->where('id', '=', $company_id)->get();
               // $orders = Order::with('UserOrder', 'Transfer')->where('company_id', '=', $company_id)->get();
          }
          $data["companies"] = $companies;
          // $data["transfers"] = Transfer::where('payee_id', '=', \Auth::guard('admin')->id())->get();;

          return view('Admin.Finance.index', $data);
     }

     function ConvertDate($daterange){
          try {
               if ($daterange){
                    $start_date = explode(' ', trim($daterange));
                    if($start_date[1] == 'Jan'){
                         $date_use = $start_date[2] . '01' . $start_date[0];
                    }elseif($start_date[1] == 'Feb'){
                         $date_use = $start_date[2] . '02' . $start_date[0];
                    }elseif($start_date[1] == 'Mar'){
                         $date_use = $start_date[2] . '03' . $start_date[0];
                    }elseif($start_date[1] == 'Apr'){
                         $date_use = $start_date[2] . '04' . $start_date[0];
                    }elseif($start_date[1] == 'May'){
                         $date_use = $start_date[2] . '05' . $start_date[0];
                    }elseif($start_date[1] == 'Jun'){
                         $date_use = $start_date[2] . '06' . $start_date[0];
                    }elseif($start_date[1] == 'Jul'){
                         $date_use = $start_date[2] . '07' . $start_date[0];
                    }elseif($start_date[1] == 'Aug'){
                         $date_use = $start_date[2] . '08' . $start_date[0];
                    }elseif($start_date[1] == 'Sep'){
                         $date_use = $start_date[2] . '09' . $start_date[0];
                    }elseif($start_date[1] == 'Oct'){
                         $date_use = $start_date[2] . '10' . $start_date[0];
                    }elseif($start_date[1] == 'Nov'){
                         $date_use = $start_date[2] . '11' . $start_date[0];
                    }elseif($start_date[1] == 'Dec'){
                         $date_use = $start_date[2] . '12' . $start_date[0];
                    }
               }
               return $date_use;
          } catch (\Exception $e) {
               return null;
          }
     }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getTranfersView(Request $request)
     {
          $user_order_transfer_id = $request->user_order_transfer_id;
          try {
               $user_order_transfer_details = UserOrderTransferDetail::with('User')->where('user_order_transfer_id', $user_order_transfer_id)->get();
               return json_encode($user_order_transfer_details);
          } catch (\Exception $e) {
               return null;
          }
     }

     public function getimage (Request $request)
     {
          $transfer = UserOrderTransferDetail::find($request->data);
          return json_encode($transfer);
     }

     public function getOrdersView(Request $request)
     {
          $order_ids = $request->order_ids;
          $company_id = $request->company_id;
          $validator = Validator::make($request->all(), [
               'order_ids' => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $orders = Order::whereIn('id', $order_ids)->get();
                    $company_arr = [];
                    foreach ($orders as $key => $order) {
                         array_push($company_arr, $order->company_id);
                    }
                    if (sizeof(array_count_values($company_arr)) > 1){
                         $return['status'] = 0;
                         $return['content'] = 'กรุณากดเลือกโอนเงินให้พาทเนอร์ทีละบริษัท';
                    } else {
                         $company = Company::find($company_id);
                         $user_orders = UserOrder::with('Currency')->where('user_id', '=', \Auth::guard('admin')->id())
                                        ->where('status', 'T')
                                        ->whereIn('order_id', $order_ids)
                                        ->with('Order.OrderProduct')
                                        ->with('Order.OrderBoxs')
                                        ->get();
                         $lak_currency = Currency::find(2);
                         $return['user_orders'] = $user_orders;
                         $return['company'] = $company;
                         $return['exchange_rate'] = $lak_currency->exchange_rate;
                         $return['status'] = 1;
                    }
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

     public function transfer(Request $request)
     {
          $company_id = $request->company_id;
          $transfer_date_thb = $request->transfer_date_thb;
          $hours_thb = $request->hours_thb;
          $minute_thb = $request->minute_thb;
          $note_thb = $request->note_thb;
          $order_ids = $request->order_id;
          $sum_thb = $request->sum_thb;
          $sum_lak = $request->sum_lak;
          $image_thb = $request->img_thb;
          // $image_lak = $request->image_lak;
          // $transfer_date_lak = $request->transfer_date_lak;
          // $hours_lak = $request->hours_lak;
          // $minutes_lak = $request->minutes_lak;
          // $note_lak = $request->note_lak;
          $validator = Validator::make($request->all(), [
               // "attach_for_order_id" => "required"
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $data = [
                         'amount_thb' => $sum_thb
                         ,'amount_lak' => $sum_lak
                         ,'company_id' => $company_id
                         ,'created_by' => \Auth::guard('admin')->id()
                         ,'created_at' => date('Y-m-d H:i:s')
                    ];
                    $last_id = PartnerOrderTransfer::insertGetId($data);

                    $currency = Currency::find(2);
                    $orders = Order::with('OrderProduct', 'OrderBoxs')->whereIn('id', $order_ids)->get();
                    $product_amount_thb = 0;
                    $product_amount_lak = 0;
                    $box_amount_thb = 0;
                    $box_amount_lak = 0;
                    $shipping_cost_thb = 0;
                    $shipping_cost_lak = 0;
                    $pack_thb = 0;
                    $pack_lak = 0;
                    $delivery_thb = 0;
                    $delivery_lak = 0;
                    foreach ($orders as $key => $order) {
                         $company = Company::find($order->company_id);
                         if ($order->currency_id == 1) {
                              $product_amount_thb = $order->OrderProduct->sum('price_bath');
                              $box_amount_thb = $order->OrderProduct->sum('price_bath');
                              // $delivery_thb = $company->delivery * ($product_amount_thb + $box_amount_thb)  / 100;
                              $shipping_cost_thb = $order->shipping_cost;
                              $delivery_thb = ($product_amount_thb + $box_amount_thb + $shipping_cost_thb) * ($company->delivery/100);
                              $pack_thb = $company->pack;
                         } else {
                              $product_amount_lak = $order->OrderProduct->sum('price_lak');
                              $box_amount_lak = $order->OrderBoxs->sum('price_lak');
                              // $delivery_lak = $company->delivery * ($product_amount_lak + $box_amount_lak) / 100;
                              $shipping_cost_lak = $order->shipping_cost;
                              $delivery_lak = ($product_amount_lak + $box_amount_lak + $shipping_cost_lak) * ($company->delivery/100);
                              $pack_lak = $company->pack * $currency->exchange_rate;
                         }
                         $data = [
                              'partner_order_transfer_id' => $last_id
                              ,'order_id' => $order->id
                              ,'product_amount_thb' => $product_amount_thb
                              ,'product_amount_lak' => $product_amount_lak
                              ,'box_amount_thb' => $box_amount_thb
                              ,'box_amount_lak' => $box_amount_lak
                              ,'delivery_amount_thb' => $shipping_cost_thb
                              ,'delivery_amount_lak' => $shipping_cost_lak
                              ,'pack_amount_thb' => $pack_thb
                              ,'pack_amount_lak' => $pack_lak
                              ,'cod_amount_thb' => $delivery_thb
                              ,'cod_amount_lak' => $delivery_lak
                              ,'created_by' => \Auth::guard('admin')->id()
                              ,'created_at' => date('Y-m-d H:i:s')
                         ];
                         PartnerOrder::insert($data);

                         $data = [
                              'status' => 'P'
                              ,'transfer_to_partner_date' => date('Y-m-d H:i:s')
                              ,'transfer_to_partner_by' => \Auth::guard('admin')->id()
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         UserOrder::where('order_id', $order->id)->update($data);
                    }

                    if ($image_thb) {
                         $fileName_thb   = time() . '.' . $image_thb->getClientOriginalExtension();
                         $img = \Image::make($image_thb->getRealPath());
                         $img->stream();

                         $data = [
                              'partner_order_transfer_id' => $last_id
                              ,'image' => 'uploads/ceo_thb_transfers/' . $fileName_thb
                              ,'amount' => $sum_thb
                              ,'currency_id' => 1
                              ,'transfer_date' => $transfer_date_thb
                              ,'transfer_hours' => $hours_thb
                              ,'transfer_minutes' => $minute_thb
                              ,'remark' => $note_thb
                              ,'status' => 'S'
                              ,'created_at' => date('Y-m-d H:i:s')
                              ,'created_by' => \Auth::guard('admin')->id()

                         ];
                         $user_order_transfer_detail_id = PartnerOrderTransferDetail::insertGetId($data);
                         if ($user_order_transfer_detail_id){
                              Storage::disk('uploads')->put('partner_thb_transfers/'.$fileName_thb, $img, 'public');
                         }
                    }
                    // if ($image_lak) {
                    //      $fileName_lak   = time() . '.' . $image_lak->getClientOriginalExtension();
                    //      $img = \Image::make($image_lak->getRealPath());
                    //      $img->stream();
                    //
                    //      $data = [
                    //           'partner_order_transfer_id' => $last_id
                    //           ,'image' => 'uploads/ceo_lak_transfers/' . $fileName_lak
                    //           ,'amount' => $sum_lak
                    //           ,'currency_id' => 1
                    //           ,'transfer_date' => $transfer_date_lak
                    //           ,'transfer_hours' => $hours_lak
                    //           ,'transfer_minutes' => $minutes_lak
                    //           ,'remark' => $note_lak
                    //           ,'status' => 'S'
                    //           ,'created_at' => date('Y-m-d H:i:s')
                    //           ,'created_by' => \Auth::guard('admin')->id()
                    //
                    //      ];
                    //      $user_order_transfer_detail_id = PartnerOrderTransferDetail::insertGetId($data);
                    //      if ($user_order_transfer_detail_id){
                    //           Storage::disk('uploads')->put('partner_lak_transfers/'.$fileName_lak, $img, 'public');
                    //      }
                    // }

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
          }
          $return['title'] = 'แนบสลิปการโอน';
          return json_encode($return);
     }

     public function getOrderView(Request $request)
     {
          $user_order_transfer_id = $request->user_order_transfer_id;
          $validator = Validator::make($request->all(), [
               // "attach_for_order_id" => "required"
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $user_order_transfer = UserOrderTransfer::with('UserOrder.Order.Transfer')
                    ->with('UserOrder.Currency')
                    ->with('UserOrder.TransferBy')
                    ->find($user_order_transfer_id);

                    \DB::commit();
                    $return['status'] = 1;
                    $return['user_order_transfer'] = $user_order_transfer;
               } catch (\Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
               }
          } else{
               $return['status'] = 0;
          }
          $return['title'] = 'แนบสลิปการโอน';
          return json_encode($return);
     }
}
