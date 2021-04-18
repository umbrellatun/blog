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

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data["titie"] = "รายการคำสั่งซื้อ";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = Menu::with(['SubMenu' => function($q){
              $q->orderBy('sort', 'asc');
         }])->orderBy('sort', 'asc')->get();
         $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->where('status', '=', 'WA')->get();
         return view('Admin.Pack.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($order_id)
    {
         $data["titie"] = "แพ็คสินค้าลงกล่อง";
         $data["users"] = User::with('Role')->get();
         $data["menus"] = Menu::orderBy('sort', 'asc')->get();
         $data["order"] = Order::with('OrderProduct.Product', 'OrderBoxs.Box', 'Transfer')->find($order_id);
         $data["currencies"] = Currency::get();
         return view('Admin.Pack.create', $data);
    }

    public function getqrcode(Request $request)
    {
         $qr_code = $request->data;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $check_order_status = false;
                   $order_product = OrderProduct::where('qr_code', '=', $qr_code)->first();
                   if ($order_product){
                        if ($order_product->status == 'S'){
                             $return['status'] = 0;
                             $return['content'] = 'สินค้าชิ้นนี้ถูกสแกนไปแล้ว';
                        } else {
                             $data = [
                                  'status' => 'S'
                                  ,'updated_by' => \Auth::guard('admin')->id()
                                  ,'updated_at' => date('Y-m-d H:i:s')
                             ];
                             OrderProduct::where('id', '=', $order_product->id)->update($data);
                             \DB::commit();
                             $check_order_status = true;
                             $return['status'] = 1;
                             $return['order_product_id'] = $order_product->id;
                             $return['content'] = 'สแกนสำเร็จ';
                        }
                   } else {
                        $order_box = OrderBoxs::where('qr_code', '=', $qr_code)->first();
                        if ($order_box) {
                             if ($order_box->status == 'S') {
                                  $return['status'] = 0;
                                  $return['content'] = 'สินค้าชิ้นนี้ถูกสแกนไปแล้ว';
                             } else {
                                  $data = [
                                       'status' => 'S'
                                  ];
                                  OrderBoxs::where('id', '=', $order_box->id)->update($data);
                                  $check_order_status = true;
                                  \DB::commit();
                                  $return['status'] = 2;
                                  $return['order_box_id'] = $order_box->id;
                                  $return['content'] = 'สแกนสำเร็จ';
                             }
                        } else {
                             $return['status'] = 0;
                             $return['content'] = 'ไม่พบ QR Code นี้';
                        }
                   }
                   if ($check_order_status == true) {
                        $prd_arr = [];
                        if ($order_product) {
                             $ord_id = $order_product->order_id;
                             $odr_prds = OrderProduct::where('order_id', '=', $ord_id)->get();
                             foreach ($odr_prds as $odr_prd) {
                                  array_push($prd_arr, $odr_prd->status);
                             }
                        }
                        if ($order_box) {
                             $ord_id = $order_box->order_id;
                             $odr_bxs = OrderBoxs::where('order_id', '=', $ord_id)->get();
                             foreach ($odr_bxs as $odr_bx) {
                                  array_push($prd_arr, $odr_bx->status);
                             }
                        }
                        if(!in_array('W', $prd_arr)){
                             \DB::beginTransaction();
                             $data = [
                                  'status' => 'P'
                                  ,'updated_by' => \Auth::guard('admin')->id()
                                  ,'updated_at' => date('Y-m-d H:i:s')
                             ];
                             Order::where('id', '=', $ord_id)->update($data);
                             \DB::commit();
                        }
                   }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
         \DB::beginTransaction();
         try {
              $data = [
                   'status' => 'W'
                   ,'updated_by' => \Auth::guard('admin')->id()
                   ,'updated_at' => date('Y-m-d H:i:s')
              ];
              OrderProduct::where('id', '=', $id)->update($data);
              $order_product = OrderProduct::find($id);
              $order_id = $order_product->order_id;
              $data = [
                   'status' => 'WA'
                   ,'updated_by' => \Auth::guard('admin')->id()
                   ,'updated_at' => date('Y-m-d H:i:s')
              ];
              Order::where('id', '=', $order_id)->update($data);
              \DB::commit();
              $return['status'] = 1;
              $return['content'] = 'รอสแกน';
         } catch (Exception $e) {
              \DB::rollBack();
              $return['status'] = 0;
              $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
         }
         $return['title'] = 'ลบข้อมูล';
         return json_encode($return);
    }

    public function destroy2($id)
    {
         \DB::beginTransaction();
         try {
              $data = [
                   'status' => 'W'
                   ,'updated_by' => \Auth::guard('admin')->id()
                   ,'updated_at' => date('Y-m-d H:i:s')
              ];
              OrderBoxs::where('id', '=', $id)->update($data);
              $order_box = OrderBoxs::find($id);
              $order_id = $order_box->order_id;
              $data = [
                   'status' => 'WA'
                   ,'updated_by' => \Auth::guard('admin')->id()
                   ,'updated_at' => date('Y-m-d H:i:s')
              ];
              Order::where('id', '=', $order_id)->update($data);
              \DB::commit();
              $return['status'] = 1;
              $return['content'] = 'รอสแกน';
         } catch (Exception $e) {
              \DB::rollBack();
              $return['status'] = 0;
              $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
         }
         $return['title'] = 'ลบข้อมูล';
         return json_encode($return);
    }
}
