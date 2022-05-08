<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\MenuRepository;
use App\Models\Shipping;
use App\User;
use Validator;

class ShippingCompanyController extends Controller
{
     public function __construct(MenuRepository $menupos)
    {
         $this->menupos = $menupos;
    }

    public function index()
    {
         $data["titie"] = "บริษัทขนส่ง";
         $data["menus"] = $this->menupos->getParentMenu();
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());

         $data["shippings"] = Shipping::orderBy('sort')->get();
         return view('Admin.ShippingCompany.list', $data);
    }

    public function store(Request $request)
    {
         $name = $request->name;
         $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'name' => $name
                        ,'status' => $use_flag
                        ,'created_by' => \Auth::guard('admin')->id()
                        ,'created_at' => date('Y-m-d H:i:s')
                   ];
                   Shipping::insert($data);
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

    public function show($id)
    {
         $box = Shipping::find($id);
         return json_encode($box);
    }

    public function update(Request $request)
    {
         $edit_name_id = $request->edit_name_id;
         $edit_name = $request->edit_name;
         $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'name' => $edit_name
                        ,'status' => $use_flag
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Shipping::where('id', '=', $edit_name_id)->update($data);
                   \DB::commit();
                   $return['status'] = 1;
                   $return['content'] = 'อัพเดทสำเร็จ';
              } catch (Exception $e) {
                   \DB::rollBack();
                   $return['status'] = 0;
                   $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
              }
         } else{
              $return['status'] = 0;
         }
         $return['title'] = 'แก้ไขข้อมูล';
         return json_encode($return);
    }

    public function destroy(Request $request)
    {
         \DB::beginTransaction();
         try {
              Shipping::where('id', '=', $request->shipping_id)->delete();
              \DB::commit();
              $return['status'] = 1;
              $return['content'] = 'ลบสำเร็จ';
         } catch (Exception $e) {
              \DB::rollBack();
              $return['status'] = 0;
              $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
         }
         $return['title'] = 'ลบข้อมูล';
         return json_encode($return);
    }
}
