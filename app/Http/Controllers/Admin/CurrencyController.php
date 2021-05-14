<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use Validator;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index()
     {
          $data["menus"] = $this->menupos->getParentMenu();
          $data["lak"] = Currency::find(2);
          return view('Admin.Currency.index', $data);
     }

     public function update(Request $request)
     {
          $lak = $request->lak;
          $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'exchange_rate' => $lak
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Currency::where('id', '=', 2)->update($data);
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
}