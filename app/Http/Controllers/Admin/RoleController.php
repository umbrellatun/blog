<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Permission;
use App\User;

use Validator;
use App\Repositories\MenuRepository;
class RoleController extends Controller
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
          $data["titie"] = "บทบาท";
          $data["menus"] = $this->menupos->getParentMenu();
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());

          $data["roles"] = Role::get();
          return view('Admin.Role.list', $data);
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
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'name' => $menu_name
                        ,'use_flag' => $use_flag
                        ,'created_by' => \Auth::guard('admin')->id()
                        ,'created_at' => date('Y-m-d H:i:s')
                   ];
                   Role::insert($data);
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
         $menu = Role::find($id);
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
                        ,'use_flag' => $use_flag
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Role::where('id', '=', $menu_id)->update($data);
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
    // public function destroy($id)
    // {
    //      \DB::beginTransaction();
    //      try {
    //           Role::where('id', '=', $id)->delete();
    //           \DB::commit();
    //           $return['status'] = 1;
    //           $return['content'] = 'อัพเดทสำเร็จ';
    //      } catch (Exception $e) {
    //           \DB::rollBack();
    //           $return['status'] = 0;
    //           $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
    //      }
    //      $return['title'] = 'ลบข้อมูล';
    //      return json_encode($return);
    // }
    public function destroy(Request $request)
    {
         \DB::beginTransaction();
         try {
              Role::where('id', '=', $request->role_id)->delete();
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

    public function permission($id)
    {
         try {
              $menus = Menu::with(['SubMenu' => function($q)use ($id){
                   $q->where('use_flag', 'Y');
                   $q->with(['Permission' => function($qq) use ($id){
                        $qq->where('role_id', '=', $id);
                   }]);
              }])->with(['Permission' => function($q)use ($id){
                   $q->where('role_id', '=', $id);
              }])->where('use_flag', 'Y')->orderBy('sort')->get();

              $return['status'] = 1;
              $return['menus'] = $menus;
         } catch (\Exception $e) {
              $return['status'] = 0;
              $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
         }
         return json_encode($return);
    }

    public function storepermision(Request $request)
    {
         // dd($request->all());
         $menu_chks = $request->menu_chk;
         $sub_menu_chks = $request->sub_menu_chk;
         $role_id = $request->role_id;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   Permission::where('role_id', '=', $role_id)->delete();
                   // dd($menu_chks);
                   foreach ($menu_chks as $key => $menu_chk) {
                        $data = [
                             'role_id' => $role_id
                             ,'menu_id' => $key
                             ,'menu_permission' => $menu_chk
                        ];
                        Permission::insert($data);
                   }
                   foreach ($sub_menu_chks as $key => $sub_menu_chk) {
                        $data = [
                             'role_id' => $role_id
                             ,'submenu_id' => $key
                             ,'submenu_permission' => $sub_menu_chk
                        ];
                        Permission::insert($data);
                   }

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
}
