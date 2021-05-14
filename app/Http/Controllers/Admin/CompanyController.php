<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Province;
use App\Models\Amphure;
use App\Models\District;

use Validator;
use App\Repositories\MenuRepository;

class CompanyController extends Controller
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
          $data["titie"] = "บริษัท";
          $data["menus"] = $this->menupos->getParentMenu();

          $data["companies"] = Company::get();
          $data["provinces"] = Province::orderBy('name_th')->get();
          // $data[""] = Amphure::get();
          // $data[""] = District::get();
          return view('Admin.Company.list', $data);
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
         $code = $request->code;
         $name = $request->name;
         $tax_id = $request->tax_id;
         $tel = $request->tel;
         $fax = $request->fax;
         $address = $request->address;
         $provinces_id = $request->provinces_id;
         $amphures_id = $request->amphures_id;
         $district = $request->district;
         $zipcode = $request->zipcode;
         $email = $request->email;
         $pick = $request->pick;
         $pack = $request->pack;
         $delivery = $request->delivery;
         $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'code' => $code
                        ,'name' => $name
                        ,'tax_id' => $tax_id
                        ,'tel' => $tel
                        ,'fax' => $fax
                        ,'address' => $address
                        ,'provinces_id' => $provinces_id
                        ,'amphures_id' => $amphures_id
                        ,'district' => $district
                        ,'zipcode' => $zipcode
                        ,'use_flag' => $use_flag
                        ,'email' => $email
                        ,'pick' => $pick
                        ,'pack' => $pack
                        ,'delivery' => $delivery
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Company::insert($data);
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
         $company = Company::find($id);
         return json_encode($company);
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
         $code = $request->code;
         $name = $request->name;
         $tax_id = $request->tax_id;
         $tel = $request->tel;
         $fax = $request->fax;
         $address = $request->address;
         $provinces_id = $request->provinces_id;
         $amphures_id = $request->amphures_id;
         $district = $request->district;
         $zipcode = $request->zipcode;
         $email = $request->email;
         $pick = $request->pick;
         $pack = $request->pack;
         $delivery = $request->delivery;
         $use_flag = isset($request->use_flag) ? $request->use_flag : 'F';
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $data = [
                        'code' => $code
                        ,'name' => $name
                        ,'tax_id' => $tax_id
                        ,'tel' => $tel
                        ,'fax' => $fax
                        ,'address' => $address
                        ,'provinces_id' => $provinces_id
                        ,'amphures_id' => $amphures_id
                        ,'district' => $district
                        ,'zipcode' => $zipcode
                        ,'use_flag' => $use_flag
                        ,'email' => $email
                        ,'pick' => $pick
                        ,'pack' => $pack
                        ,'delivery' => $delivery
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Company::where('code', '=', $code)->update($data);
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
              Company::where('id', '=', $request->role_id)->delete();
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

    public function get_amphures(Request $request)
     {
          $province_id = $request->province_id;
          $get_amphures = Amphure::where('province_id', '=', $province_id)->get();
          return json_encode($get_amphures);
     }

    public function get_districts(Request $request)
     {
          $amphures_id = $request->amphures_id;
          $get_districts = District::where('district_id', '=', $amphures_id)->get();
          return json_encode($get_districts);
     }

     public function get_zipcode(Request $request)
     {
          $district_id = $request->district_id;
          $districts = District::find($district_id);
          return json_encode($districts);
     }
}
