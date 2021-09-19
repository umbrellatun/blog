<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Transfer;

use App\User;
use Validator;
use Storage;
use App\Repositories\MenuRepository;

class TransferController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index($order_id)
     {
          $data["titie"] = "รายการหลักฐานการโอนเงิน";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();
          $data["order"] = Order::with('Transfer')->find($order_id);
          $data["transfers"] = Transfer::with('User')->where('order_id', '=', $order_id)->get();
          return view('Admin.Transfer.list', $data);
     }

    public function create($order_id)
    {
         $data["titie"] = "แนบสลิปการโอนเงิน";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["users"] = User::with('Role')->get();
         $data["menus"] = $this->menupos->getParentMenu();
         $data["order"] = Order::with('Transfer')->find($order_id);
         $data["currencies"] = Currency::get();
         return view('Admin.Transfer.create', $data);
    }

    public function edit($transfer_id)
    {
         $data["titie"] = "แนบสลิปการโอนเงิน";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["users"] = User::with('Role')->get();
         $data["menus"] = $this->menupos->getParentMenu();
         $data["currencies"] = Currency::get();
         $data["transfer"] = Transfer::with('Order')->find($transfer_id);
         return view('Admin.Transfer.edit', $data);
    }

    public function store2(Request $request)
    {
         
    }

    public function store(Request $request, $order_id)
    {
         $price = $request->price;
         $currency_id = $request->currency_id;
         $transfer_date = (date_create($request->transfer_date));
         $transfer_date = date_format($transfer_date, 'Y-m-d');
         $hours = $request->hours;
         $minutes = $request->minutes;
         $note = $request->note;
         $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                 if ($request->hasFile('image')) {
                     $image      = $request->file('image');
                     $fileName   = time() . '.' . $image->getClientOriginalExtension();
                     $img = \Image::make($image->getRealPath());
                     // $img->resize(120, 120, function ($constraint) {
                     //      $constraint->aspectRatio();
                     // });
                     $img->stream();
                } else {
                     $fileName = '';
                }

                $data = [
                     'order_id' => $order_id
                     ,'image' => $fileName
                     ,'amount' => $price
                     ,'currency_id' => $currency_id
                     ,'transfer_date' => $transfer_date
                     ,'transfer_hours' => $hours
                     ,'transfer_minutes' => $minutes
                     ,'remark' => $note
                     ,'status' => 'W'
                     ,'created_by' => \Auth::guard('admin')->id()
                     ,'created_at' => date('Y-m-d H:i:s')
                ];
                $transfer_id = Transfer::insertGetId($data);
                if ($transfer_id){
                     Storage::disk('uploads')->put('transfers/'.$fileName, $img, 'public');

                     $transfer_status = array();
                     $transfers = Transfer::where('order_id', $order_id)->get();
                     foreach ($transfers as $key => $transfer) {
                          array_push($transfer_status, $transfer->status);
                     }

                     if (in_array('W', $transfer_status)){
                          $data = [
                               'status' => 'WA'
                               ,'updated_by' => \Auth::guard('admin')->id()
                               ,'updated_at' => date('Y-m-d H:i:s')
                          ];
                          Order::where('id', '=', $order_id)->update($data);
                     }
                }
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'จัดเก็บสำเร็จ';
            }catch (Exception $e) {
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


    public function update(Request $request, $transfer_id)
    {
         $price = $request->price;
         $currency_id = $request->currency_id;
         $transfer_date = (date_create($request->transfer_date));
         $transfer_date = date_format($transfer_date, 'Y-m-d');
         $hours = $request->hours;
         $minutes = $request->minutes;
         $note = $request->note;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   if ($request->hasFile('image')) {
                        $transfer = Transfer::find($transfer_id);
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
                            ,'amount' => $price
                            ,'currency_id' => $currency_id
                            ,'transfer_date' => $transfer_date
                            ,'transfer_hours' => $hours
                            ,'transfer_minutes' => $minutes
                            ,'remark' => $note
                            ,'status' => 'W'
                            ,'updated_by' => \Auth::guard('admin')->id()
                            ,'updated_at' => date('Y-m-d H:i:s')
                       ];
                   } else {
                        $data = [
                            'amount' => $price
                            ,'currency_id' => $currency_id
                            ,'transfer_date' => $transfer_date
                            ,'transfer_hours' => $hours
                            ,'transfer_minutes' => $minutes
                            ,'remark' => $note
                            ,'status' => 'W'
                            ,'updated_by' => \Auth::guard('admin')->id()
                            ,'updated_at' => date('Y-m-d H:i:s')
                       ];
                   }
                   Transfer::where('id', '=', $transfer_id)->update($data);
                   \DB::commit();
                   $return['status'] = 1;
                   $return['content'] = 'จัดเก็บสำเร็จ';
              }catch (Exception $e) {
                   \DB::rollBack();
                   $return['status'] = 0;
                   $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
              }
         } else{
              $return['status'] = 0;
         }
         $return['title'] = 'อัพเดทข้อมูล';
         return json_encode($return);
    }

    public function getimage (Request $request)
    {
        $transfer = Transfer::with('Order')->find($request->data);
        return json_encode($transfer);
    }

    public function approve(Request $request)
    {
         $transfer_id = $request->transfer_id;
         $value = $request->value;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'status' => $value
                        ,'payee_id' => \Auth::guard('admin')->id()
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Transfer::where('id', '=', $transfer_id)->update($data);
                   if ($value == 'Y') {
                        $tran = Transfer::with('Order')->find($transfer_id);
                        $status_arr = [];
                        $transfers = Transfer::where('order_id', '=', $tran->Order->id)->get();
                        foreach ($transfers as $transfer) {
                             array_push($status_arr, $transfer->status);
                        }
                        if(!in_array('W', $status_arr)){
                             $data = [
                                  'status' => 'P'
                                  ,'updated_by' => \Auth::guard('admin')->id()
                                  ,'updated_at' => date('Y-m-d H:i:s')
                             ];
                             Order::where('id', '=', $tran->Order->id)->update($data);
                        }
                   } else {
                        $tran = Transfer::with('Order')->find($transfer_id);
                        $data = [
                             'status' => 'W'
                             ,'updated_by' => \Auth::guard('admin')->id()
                             ,'updated_at' => date('Y-m-d H:i:s')
                        ];
                        Order::where('id', '=', $tran->Order->id)->update($data);
                   }
                   \DB::commit();

                   $return["user"] = User::find(\Auth::guard('admin')->id());
                   $return['status'] = 1;
                   $return['content'] = 'จัดเก็บสำเร็จ';
              }catch (Exception $e) {
                   \DB::rollBack();
                   $return['status'] = 0;
                   $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
              }
         } else{
              $return['status'] = 0;
         }
         $return['title'] = 'อัพเดทข้อมูล';
         return json_encode($return);
    }
}
