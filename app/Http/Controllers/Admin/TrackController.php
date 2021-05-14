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

class TrackController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index($order_id)
    {
         $data["title"] = "ติดตามคำสั่งซื้อ";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = $this->menupos->getParentMenu();

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
                   if (strlen($tracking_number) > 0){
                       $status = 'T';
                   } else {
                        $status = 'P';
                   }
                   $data = [
                        'tracking_number' => $tracking_number
                        ,'status' => $status
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Order::where('id', '=', $order_id)->update($data);


                   \DB::commit();
                   $return['status'] = 1;
                   $return['content'] = 'บันทึกสำเร็จ';
              } catch (Exception $e) {
                   \DB::rollBack();
                   $return['status'] = 0;
                   $return['content'] = 'บันทึกไม่สำเร็จ'.$e->getMessage();
              }
         } else{
              $return['status'] = 0;
         }
         $return['title'] = 'Tracking number';
         return json_encode($return);
    }
}
