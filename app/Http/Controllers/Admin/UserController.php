<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Role;
use App\User;
use Validator;
use Storage;
use Illuminate\Support\Facades\Hash;
use App\Repositories\MenuRepository;

class UserController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // dd(\Auth::guard('admin')->id());
         $data["titie"] = "จัดการผู้ใช้งาน";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["users"] = User::with('Role')->get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = $this->menupos->getParentMenu();

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
        $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
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
                   if ($request->hasFile('image')) {
                        $image      = $request->file('image');
                        $fileName   = time() . '.' . $image->getClientOriginalExtension();

                        $img = \Image::make($image->getRealPath());
                        $img->resize(120, 120, function ($constraint) {
                             $constraint->aspectRatio();
                        });
                        $img->stream();
                        Storage::disk('uploads')->put('users/'.$fileName, $img, 'public');
                   } else {
                        $fileName = '';
                   }
                   $data = [
                        'name' => $name
                        ,'lastname' => $lastname
                        ,'id_card_no' => $id_card_no
                        ,'company_id' => $company
                        ,'role_id' => $role
                        ,'email' => $email
                        ,'password' => Hash::make($password)
                        ,'use_flag' => $use_flag
                        ,'profile_image' => isset($fileName) ? $fileName : ''
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
        $user = User::find($id);
        return json_encode($user);
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
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
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
                   if ($request->hasFile('image')) {
                        $user = User::find($id);
                        $image      = $request->file('image');
                        $fileName   = time() . '.' . $image->getClientOriginalExtension();

                        $img = \Image::make($image->getRealPath());
                        $img->resize(120, 120, function ($constraint) {
                             $constraint->aspectRatio();
                        });
                        $img->stream();

                        if (Storage::disk("uploads")->exists("users/".$user->profile_image)){
                             Storage::disk("uploads")->delete("users/".$user->profile_image);
                        }
                        Storage::disk('uploads')->put('users/'.$fileName, $img, 'public');
                        $data = [
                             'name' => $name
                             ,'lastname' => $lastname
                             ,'id_card_no' => $id_card_no
                             ,'company_id' => $company
                             ,'role_id' => $role
                             ,'email' => $email
                             ,'use_flag' => $use_flag
                             ,'profile_image' => $fileName
                             ,'updated_by' => \Auth::guard('admin')->id()
                             ,'updated_at' => date('Y-m-d H:i:s')
                        ];
                   } else {
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
                   }

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
    // public function destroy($id)
    // {
    //      \DB::beginTransaction();
    //      try {
    //           User::where('id', '=', $id)->delete();
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
              User::where('id', '=', $request->user_id)->delete();
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

    public function reset_password(Request $request){
         $user_id = $request->user_id;
         $password = $request->password;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'password' => \Hash::make($password)
                   ];
                   User::where('id', '=', $user_id)->update($data);

                   \DB::commit();
                   $return['status'] = 1;
                   $return['content'] = 'สำเร็จ';
              } catch (Exception $e) {
                   \DB::rollBack();
                   $return['status'] = 0;
                   $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
              }
         }else{
              $return['status'] = 0;
         }
         $return['title'] = 'รีเซ็ตรหัสผ่าน';
         return json_encode($return);
    }
}
