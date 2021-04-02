<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Role;
use App\User;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data["titie"] = "จัดการผู้ใช้งาน";
         $data["users"] = User::get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = Menu::orderBy('sort', 'asc')->get();
         return view('Admin.User.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["titie"] = "เพิ่มผู้ใช้งาน";
        $data["users"] = User::get();
        $data["menus"] = Menu::orderBy('sort', 'asc')->get();
        $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
        $data["roles"] = Role::where('use_flag', '=', 'Y')->get();
        return view('Admin.User.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         dd($request->all());
        $email = $request->email;
        $name = $request->name;
        $lastname = $request->lastname;
        $password = $request->password;
        $password_confirm = $request->password_confirm;
        $id_card_no = $request->id_card_no;
        $company = $request->company;
        $role = $request->role;
        $use_flag = isset($request->use_flag) ? 'Y' : 'N';
        $validator = Validator::make($request->all(), [

        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                  $data = [
                       'name' => $name
                       ,'lastname' => $lastname
                       ,'id_card_no' => $id_card_no
                       ,'company_id' => $company
                       ,'role_id' => $role
                       ,'email' => $email
                       ,'password' => $password
                       ,'use_flag' => $use_flag
                       ,'created_by' => \Auth::guard('admin')->id()
                       ,'created_at' => date('Y-m-d H:i:s')
                  ];
                  User::insert($data);
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
         $data["titie"] = "แก้ไขผู้ใช้งาน";
         $data["users"] = User::get();
         $data["menus"] = Menu::orderBy('sort', 'asc')->get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["roles"] = Role::where('use_flag', '=', 'Y')->get();
         $data["user"] = User::find($id);
         return view('Admin.User.edit', $data);
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
         $email = $request->email;
         $name = $request->name;
         $lastname = $request->lastname;
         $id_card_no = $request->id_card_no;
         $company = $request->company;
         $role = $request->role;
         $use_flag = isset($request->use_flag) ? 'Y' : 'N';
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'name' => $name
                        ,'lastname' => $lastname
                        ,'id_card_no' => $id_card_no
                        ,'company_id' => $company
                        ,'role_id' => $role
                        ,'email' => $email
                        ,'use_flag' => $use_flag
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   User::where('id', '=', $id)->update($data);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
