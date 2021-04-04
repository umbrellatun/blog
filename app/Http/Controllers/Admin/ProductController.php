<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Role;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RunNo;
use App\Models\Currency;
use App\User;
use Validator;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data["titie"] = "จัดการสินค้า";
         $data["users"] = User::with('Role')->get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = Menu::orderBy('sort', 'asc')->get();
         $data["products"] = Product::where('use_flag', '=', 'Y')->get();
         return view('Admin.Product.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["titie"] = "เพิ่มสินค้า";
        $data["users"] = User::with('Role')->get();
        $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
        $data["menus"] = Menu::orderBy('sort', 'asc')->get();
        $data["product_types"] = ProductType::get();
        $run_no = RunNo::where('prefix', '=', 'sku')->first();
        $this_year = date('Y'); $this_month = date('m'); $this_day = date('d');
        if ($run_no->year != $this_year || $run_no->month != $this_month || $run_no->day != $this_day){
             $qty = 1;
        } else {
             $qty = $run_no->qty + 1;
        }
        $data["qty"] = $this_year.$this_month.$this_day . "-" . str_pad($qty, 3, "0", STR_PAD_LEFT) ;
        return view('Admin.Product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $sku = $request->sku;
         $name = $request->name;
         $product_type = $request->product_type;
         $company = $request->company;
         $price_bath = $request->price_bath;
         $price_lak = $request->price_lak;
         $use_flag = $request->use_flag;
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
                        Storage::disk('uploads')->put('products/'.$fileName, $img, 'public');
                   } else {
                        $fileName = '';
                   }
                   $data = [
                        'sku' => $sku
                        ,'name' => $name
                        ,'product_type_id' => $product_type
                        ,'company_id' => $company
                        ,'price_bath' => str_replace(",", "", $price_bath)
                        ,'price_lak' => str_replace(",", "", $price_lak)
                        ,'image' => isset($fileName) ? $fileName : ''
                        ,'use_flag' => $use_flag
                        ,'created_by' => \Auth::guard('admin')->id()
                        ,'created_at' => date('Y-m-d H:i:s')
                   ];
                   Product::insert($data);

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
        //
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
        //
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
