<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Validator;
use App\Repositories\MenuRepository;

class MenuController extends Controller
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

     public function index()
     {
          $data["titie"] = "จัดการเมนู";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();

          return view('Admin.Menu.list', $data);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $menu_name = $request->menu_name;
         $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
         $icon = $request->icon;
         $link = $request->link;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'name' => $menu_name
                        ,'icon' => $icon
                        ,'link' => $link
                        ,'use_flag' => $use_flag
                        ,'created_at' => date('Y-m-d H:i:s')
                   ];
                   Menu::insert($data);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::find($id);
        return json_encode($menu);
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
    public function update(Request $request)
    {
        $menu_id = $request->menu_id;
        $menu_name = $request->menu_name;
        $icon = $request->icon;
        $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                  $data = [
                       'name' => $menu_name
                       ,'icon' => $icon
                       // ,'link' => $link
                       ,'use_flag' => $use_flag
                       ,'updated_at' => date('Y-m-d H:i:s')
                  ];
                  Menu::where('id', '=', $menu_id)->update($data);
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
              Menu::where('id', '=', $id)->delete();
              \DB::commit();
              $return['status'] = 1;
              $return['content'] = 'อัพเดทสำเร็จ';
         } catch (Exception $e) {
              \DB::rollBack();
              $return['status'] = 0;
              $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
         }
         $return['title'] = 'ลบข้อมูล';
         return json_encode($return);
    }
}
