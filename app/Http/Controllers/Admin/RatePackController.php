<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use Validator;
use App\Models\Setting;
use Illuminate\Http\Request;

class RatePackController extends Controller
{
     public function __construct(MenuRepository $menupos)
    {
         $this->menupos = $menupos;
    }

    public function index()
    {
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         $data["setting"] = Setting::find(2);
         return view('Admin.Setting.pack', $data);
    }

    public function update(Request $request)
    {
         $price = $request->price;
         $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                  $data = [
                       'price' => $price
                       ,'updated_by' => \Auth::guard('admin')->id()
                       ,'updated_at' => date('Y-m-d H:i:s')
                  ];
                  Setting::where('id', '=', 2)->update($data);
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
