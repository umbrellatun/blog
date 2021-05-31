<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\MenuRepository;
use App\Models\Box;
use Validator;
class BoxController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
     }

     public function index()
     {
          $data["titie"] = "กล่อง";
          $data["menus"] = $this->menupos->getParentMenu();
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          
          $data["boxs"] = Box::get();
          return view('Admin.Box.list', $data);
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
         $size = $request->size;
         $description = $request->description;
         $price_bath = $request->price_bath;
         $price_lak = $request->price_lak;
         $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'size' => $size
                        ,'description' => $description
                        ,'use_flag' => $use_flag
                        ,'price_bath' => $price_bath
                        ,'price_lak' => $price_lak
                        ,'created_by' => \Auth::guard('admin')->id()
                        ,'created_at' => date('Y-m-d H:i:s')
                   ];
                   Box::insert($data);
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
         $box = Box::find($id);
         return json_encode($box);
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
         $size_id = $request->size_id;
         $size = $request->size;
         $description = $request->description;
         $price_bath = $request->price_bath;
         $price_lak = $request->price_lak;
         $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'size' => $size
                        ,'description' => $description
                        ,'price_bath' => $price_bath
                        ,'price_lak' => $price_lak
                        ,'use_flag' => $use_flag
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Box::where('id', '=', $size_id)->update($data);
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

    public function destroy(Request $request)
    {
         \DB::beginTransaction();
         try {
              Box::where('id', '=', $request->box_id)->delete();
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
