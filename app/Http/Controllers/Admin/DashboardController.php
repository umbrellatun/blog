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

use App\Repositories\MenuRepository;
use \Mpdf\Mpdf;
use Validator;

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
          $data["user_orders"] = UserOrder::with('Currency', 'Order')->where('user_id', '=', \Auth::guard('admin')->id())->where('status', 'S')->get();
          if ($request->daterange){
               $daterange = $request->daterange;
               $str_date = explode('-', $daterange);
               $start_date = trim($str_date[0]);
               $end_date = trim($str_date[1]);
               $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
               $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
               $transfers = Transfer::where('created_at', '>=', $start_date)
                                             ->where('created_at', '<=', $end_date)
                                             ->where('payee_id', '=', \Auth::guard('admin')->id());

          }else{
               $data["start_date"] = '';
               $data["end_date"] = '';
               $transfers = Transfer::where('payee_id', '=', \Auth::guard('admin')->id());
          }
          $data["transfers"] = $transfers->paginate(10)->appends(request()->query());
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
                    $return['orders'] = $orders;
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
