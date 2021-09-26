<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\User;
use App\Models\Company;
use App\Models\Transfer;
use App\Models\Shipping;
use App\Models\Currency;
use App\Models\UserOrder;
use App\Models\ShippingOrder;
use App\Models\UserOrderTransfer;
use App\Models\UserOrderTransferDetail;

use App\Repositories\MenuRepository;
use \Mpdf\Mpdf;
use Validator;
use Storage;

class DashboardController extends Controller
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
          $data["titie"] = "รายการหลักฐานการโอนเงิน";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          // $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();
          $data["orders"] = $orders = Order::with(['Customer', 'Company', 'OrderProduct', 'OrderBoxs'])->get();
          $data["transfers"] = Transfer::with('Order', 'Currency')->where('status', 'W')->get();
          $data["shippings"] = Shipping::where('status', '=', 'Y')->get();
          $data["currencies"] = Currency::where('use_flag', 'Y')->get();
          $user_orders = UserOrder::with('Currency', 'Order')->where('user_id', '=', \Auth::guard('admin')->id())->where('status', 'S');
          if ($request->daterange){
               $daterange = $request->daterange;
               $str_date = explode('-', $daterange);
               $start_date = trim($str_date[0]);
               $end_date = trim($str_date[1]);
               $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
               $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
               $data["transfers"] = Transfer::where('created_at', '>=', $start_date)
                                             ->where('created_at', '<=', $end_date)
                                             ->where('payee_id', '=', \Auth::guard('admin')->id());

          }else{
               $data["start_date"] = '';
               $data["end_date"] = '';
               $data["transfers"] = Transfer::where('payee_id', '=', \Auth::guard('admin')->id());
          }
          $data["user_orders"] = $user_orders->paginate(10)->appends(request()->query());
          return view('Admin.Dashboard.index', $data);
     }

     public function getShippingsView(Request $request)
     {
          $shipping_id = $request->shipping_id;
          $validator = Validator::make($request->all(), [
               'shipping_id' => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $shipping_orders = ShippingOrder::where('status', 'S')->where('shipping_id', $shipping_id)->get();
                    $order_arr = [];
                    foreach ($shipping_orders as $key => $shipping_order) {
                         array_push($order_arr, $shipping_order->order_id);
                    }
                    $orders = Order::with(['Customer.LaosDistrict', 'OrderBoxs', 'OrderProduct'])
                                   ->with(['Transfer', 'Currency'])
                                   ->with('LaosDistrict')
                                   ->whereIn('id', $order_arr)
                                   ->where('status', 'T')
                                   ->get();
                    $shipping = Shipping::find($shipping_id);
                    $return['orders'] = $orders;
                    $return['shipping_name'] = $shipping->name;
                    $return['status'] = 1;
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

     public function getOrdersView(Request $request)
     {
          $order_ids = $request->order_ids;
          $validator = Validator::make($request->all(), [
               'order_ids' => 'required'
          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $user_orders = UserOrder::with('Currency', 'Order')->where('user_id', '=', \Auth::guard('admin')->id())
                                   ->where('status', 'S')
                                   ->whereIn('id', $order_ids)
                                   ->get();

                    $return['user_orders'] = $user_orders;
                    $return['status'] = 1;
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
         $order_ids = $request->order_id;

         $transfer_date_thb = $request->transfer_date_thb;
         $hours_thb = $request->hours_thb;
         $minutes_thb = $request->minutes_thb;
         $note_thb = $request->note_thb;
         $image_thb = $request->image_thb;

         $transfer_date_lak = $request->transfer_date_lak;
         $hours_lak = $request->hours_lak;
         $minutes_lak = $request->minutes_lak;
         $note_lak = $request->note_lak;
         $image_lak = $request->image_lak;

         $sum_bath = $request->sum_bath;
         $sum_lak = $request->sum_lak;
         $validator = Validator::make($request->all(), [
              // "attach_for_order_id" => "required"
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                 foreach ($order_ids as $key => $order_id) {
                     $data = [
                          'status' => 'T'
                          ,'transfer_date' => date('Y-m-d H:i:s')
                          ,'transfer_by' => \Auth::guard('admin')->id()
                          ,'updated_at' => date('Y-m-d H:i:s')
                          ,'updated_by' => \Auth::guard('admin')->id()
                     ];
                     UserOrder::where('order_id', '=', $order_id)->update($data);
                 }

                 $data = [
                      'amount_thb' => $sum_bath
                      ,'amount_lak' => $sum_lak
                      ,'created_at' => date('Y-m-d H:i:s')
                      ,'created_by' => \Auth::guard('admin')->id()
                 ];
                 $user_order_transfer_id = UserOrderTransfer::insertGetId($data);

                 if ($image_thb) {
                      $fileName   = time() . '.' . $image_thb->getClientOriginalExtension();
                      $img = \Image::make($image_thb->getRealPath());
                      $img->stream();

                      $data = [
                           'user_order_transfer_id' => $user_order_transfer_id
                           ,'image' => $img
                           ,'amount' => $sum_bath
                           ,'currency_id' => 1
                           ,'transfer_date' => $transfer_date_thb
                           ,'transfer_hours' => $hours_thb
                           ,'transfer_minutes' => $minutes_thb
                           ,'remark' => $note_thb
                           ,'status' => 'S'
                           ,'created_at' => date('Y-m-d H:i:s')
                           ,'created_by' => \Auth::guard('admin')->id()

                      ];
                      $user_order_transfer_detail_id = UserOrderTransferDetail::insertGetId($data);
                      if ($user_order_transfer_detail_id){
                           Storage::disk('uploads')->put('ceo_thb_transfers/'.$fileName, $img, 'public');
                      }
                 }
                 if ($image_lak) {
                      $fileName   = time() . '.' . $image_lak->getClientOriginalExtension();
                      $img = \Image::make($image_lak->getRealPath());
                      $img->stream();

                      $data = [
                           'user_order_transfer_id' => $user_order_transfer_id
                           ,'image' => $img
                           ,'amount' => $sum_lak
                           ,'currency_id' => 1
                           ,'transfer_date' => $transfer_date_lak
                           ,'transfer_hours' => $hours_lak
                           ,'transfer_minutes' => $minutes_lak
                           ,'remark' => $note_lak
                           ,'status' => 'S'
                           ,'created_at' => date('Y-m-d H:i:s')
                           ,'created_by' => \Auth::guard('admin')->id()

                      ];
                      $user_order_transfer_detail_id = UserOrderTransferDetail::insertGetId($data);
                      if ($user_order_transfer_detail_id){
                           Storage::disk('uploads')->put('ceo_lak_transfers/'.$fileName, $img, 'public');
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
       }
       $return['title'] = 'แนบสลิปการโอน';
       return json_encode($return);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
          //
     }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
          //
     }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
     {
          //
     }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
          //
     }

     public function orderStatus($orderStatus)
     {
          if ($orderStatus == 'W') {
               $title = 'รอแนบหลักฐานการโอน';
          } elseif($orderStatus == 'WA'){
               $title = 'ตรวจสอบหลักฐานการโอนแล้ว รอแพ็ค';
          } elseif($orderStatus == 'P'){
               $title = 'แพ็คสินค้าแล้ว อยู่ระหว่างจัดส่ง';
          } elseif($orderStatus == 'T'){
               $title = 'จัดส่งแล้ว รอปรับสถานะ';
          } elseif($orderStatus == 'S'){
               $title = 'เสร็จสมบูรณ์';
          } elseif($orderStatus == 'C'){
               $title = 'Cancel';
          }
          $data["titie"] = $title;
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = $this->menupos->getParentMenu();
          $data["order_status"] = $orderStatus;
          $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->where('status', '=', $orderStatus)->get();
          return view('Admin.Order.list', $data);
     }

     public function printInvoice($id)
     {
          $order_ids = explode(",", $id);
          if (sizeof($order_ids) > 0){
               $data["orders"] = $orders = Order::with('OrderProduct.Product')
                                        ->with('OrderBoxs.Box')
                                        ->with('Transfer')
                                        ->with('LaosDistrict')
                                        ->with('Company.Province')
                                        ->with('Company.Amphure')
                                        ->with('Company.District')
                                        ->whereIn('id', $order_ids)
                                        ->get();
               $data2 = view('Admin.Dashboard.invoice', $data);
               $mpdf = new Mpdf([
                    'autoLangToFont' => true,
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'margin_top' => 0,
                    'margin_left' => 0,
                    'margin_right' => 0,
                    'margin_bottom' => 0,
               ]);
               $mpdf->SetDisplayMode('fullpage');
               $mpdf->list_indent_first_level = 0;
               // $mpdf->setFooter('{PAGENO}');
               // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
               $mpdf->WriteHTML($data2);
               $mpdf->Output('Invoice_'. date('Y_m_d') .'.pdf', 'I');

          }
     }

     public function getOrderAddress($order_id)
     {
          try {
               $order = Order::with('LaosDistrict')->find($order_id);
               $address = $order->customer_address;
               $city = $order->customer_city;
               $district = $order->LaosDistrict->name;
               $phone_number = $order->customer_phone_number;

               $addr = $address . " " . $city . "<br/>" . $district . " " . $phone_number;
               return $addr;
          } catch (\Exception $e) {
               return null;
          }
     }
}
