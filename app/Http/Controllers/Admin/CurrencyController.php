<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use Validator;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Box;

use Illuminate\Http\Request;
use App\User;

class CurrencyController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index()
     {
          $data["title"] = 'ค่าเงิน';
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::where('id', '<>', 1)->where('use_flag', 'Y')->get();
          return view('Admin.Currency.index', $data);
     }

     public function update(Request $request)
     {
          $value = $request->value;
          $validator = Validator::make($request->all(), [

          ]);
          if (!$validator->fails()) {
               \DB::beginTransaction();
               try {
                    $data = [
                         'exchange_rate' => $value
                         ,'updated_by' => \Auth::guard('admin')->id()
                         ,'updated_at' => date('Y-m-d H:i:s')
                    ];
                    Currency::where('id', '=', $request->edit_id)->update($data);

                    $products = Product::get();
                    foreach ($products as $key => $product) {
                         $data = [
                              'price_lak' => $product->price_bath * $value
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Product::where('id', $product->id)->update($data);
                    }

                    $boxs = Box::get();
                    foreach ($boxs as $key => $box) {
                         $data = [
                              'price_lak' => $box->price_bath * $value
                              ,'updated_by' => \Auth::guard('admin')->id()
                              ,'updated_at' => date('Y-m-d H:i:s')
                         ];
                         Box::where('id', $box->id)->update($data);
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
          $return['title'] = 'เพิ่มข้อมูล';
          return json_encode($return);
     }

     public function getMoney(Request $request)
     {
          $currency = Currency::find($request->value);
          return json_encode($currency);
     }
}
