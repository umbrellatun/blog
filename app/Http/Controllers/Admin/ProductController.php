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
use App\Models\ProductStock;
use App\User;
use Validator;
use Storage;
use \Mpdf\Mpdf;
use App\Repositories\MenuRepository;
use App\Repositories\UserRepository;

class ProductController extends Controller
{
     public function __construct(MenuRepository $menupos, UserRepository $userpos)
     {
          $this->menupos = $menupos;
          $this->userpos = $userpos;
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data["titie"] = "จัดการสินค้า";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["users"] = User::with('Role')->get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = $this->menupos->getParentMenu();

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
        $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
        $data["users"] = $user = User::with('Role')->get();
        $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
        $data["menus"] = $this->menupos->getParentMenu();
        $data["product_types"] = ProductType::get();
        $data["currencies"] = Currency::get();
        // $run_no = RunNo::where('prefix', '=', 'sku')->first();
        // $this_year = date('Y'); $this_month = date('m'); $this_day = date('d');
        // $qty = 1;
        // if ($run_no) {
        //      if ($run_no->year != $this_year || $run_no->month != $this_month || $run_no->day != $this_day){
        //           $qty = 1;
        //      } else {
        //           $qty = $run_no->qty + 1;
        //      }
        // }
        // $data["qty"] = $this_year.$this_month.$this_day . "-" . str_pad($qty, 3, "0", STR_PAD_LEFT) ;
        $data["qty"] = 'PROD-' . date('Ymd') . '-' . date('His');
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
         $price_bath = isset($request->price_bath) ? $request->price_bath : 0;
         $price_lak = isset($request->price_lak) ? $request->price_lak : 0;
         $price_usd = isset($request->price_usd) ? $request->price_usd : 0;
         $price_khr = isset($request->price_khr) ? $request->price_khr : 0;
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
                        $fileName = 'prod-0.jpg';
                   }
                   $data = [
                        'sku' => $sku
                        ,'name' => $name
                        ,'product_type_id' => $product_type
                        ,'company_id' => $company
                        ,'price_bath' => str_replace(",", "", $price_bath)
                        ,'price_lak' => str_replace(",", "", $price_lak)
                        ,'price_usd' => str_replace(",", "", $price_usd)
                        ,'price_khr' => str_replace(",", "", $price_khr)
                        ,'image' => isset($fileName) ? $fileName : 'prod-0.jpg'
                        ,'use_flag' => $use_flag
                        ,'created_by' => \Auth::guard('admin')->id()
                        ,'created_at' => date('Y-m-d H:i:s')
                   ];
                   $last_product_id = Product::insertGetId($data);

                   $data = [
                        "product_id" => $last_product_id
                        ,"plus" => 0
                        ,"delete" => 0
                        ,"stock" => 0
                        ,'created_by' => \Auth::guard('admin')->id()
                        ,'created_at' => date('Y-m-d H:i:s')
                   ];
                   ProductStock::insert($data);
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
         $data["titie"] = "แก้ไขสินค้า";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["users"] = User::with('Role')->get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = $this->menupos->getParentMenu();
         $data["product_types"] = ProductType::get();
         $data["product"] = Product::find($id);
         $data["currencies"] = Currency::get();
         return view('Admin.Product.edit', $data);
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
         $name = $request->name;
         $product_type = $request->product_type;
         $company = $request->company;
         $price_bath = isset($request->price_bath) ? $request->price_bath : 0;
         $price_lak = isset($request->price_lak) ? $request->price_lak : 0;
         $price_usd = isset($request->price_usd) ? $request->price_usd : 0;
         $price_khr = isset($request->price_khr) ? $request->price_khr : 0;
         $use_flag = $request->use_flag;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   if ($request->hasFile('image')) {
                        $product = Product::find($id);
                        $image      = $request->file('image');
                        $fileName   = time() . '.' . $image->getClientOriginalExtension();

                        $img = \Image::make($image->getRealPath());
                        $img->resize(120, 120, function ($constraint) {
                             $constraint->aspectRatio();
                        });
                        $img->stream();

                        if (Storage::disk("uploads")->exists("products/".$product->image)){
                             Storage::disk("uploads")->delete("products/".$product->image);
                        }
                        Storage::disk('uploads')->put('products/'.$fileName, $img, 'public');
                        $data = [
                             'name' => $name
                             ,'product_type_id' => $product_type
                             ,'company_id' => $company
                             ,'price_bath' => str_replace(",", "", $price_bath)
                             ,'price_lak' => str_replace(",", "", $price_lak)
                             ,'price_usd' => str_replace(",", "", $price_usd)
                             ,'price_khr' => str_replace(",", "", $price_khr)
                             ,'image' => isset($fileName) ? $fileName : ''
                             ,'use_flag' => $use_flag
                             ,'updated_by' => \Auth::guard('admin')->id()
                             ,'updated_at' => date('Y-m-d H:i:s')
                        ];
                   } else {
                        $data = [
                             'name' => $name
                             ,'product_type_id' => $product_type
                             ,'company_id' => $company
                             ,'price_bath' => str_replace(",", "", $price_bath)
                             ,'price_lak' => str_replace(",", "", $price_lak)
                             ,'price_usd' => str_replace(",", "", $price_usd)
                             // ,'image' => 'prod-0.jpg'
                             ,'price_khr' => str_replace(",", "", $price_khr)
                             ,'use_flag' => $use_flag
                             ,'updated_by' => \Auth::guard('admin')->id()
                             ,'updated_at' => date('Y-m-d H:i:s')
                        ];
                   }

                   Product::where('id', '=', $id)->update($data);
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
    public function destroy(Request $request)
    {
         \DB::beginTransaction();
         try {
              Product::where('id', '=', $request->product_id)->delete();
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

    public function qrcode($id)
    {
         $data['product'] = Product::with(['Company', 'ProductType'])->find($id);
         // return view('Admin.Product.qr_code', $data);
         $data2 = view('Admin.Product.qr_code', $data);
         $mpdf = new Mpdf([
              'autoLangToFont' => true,
              'mode' => 'utf-8',
              'format' => [101.6, 152.4],
              'margin_top' => 0,
              'margin_left' => 0,
              'margin_right' => 0,
              'margin_bottom' => 0,
         ]);
         // $mpdf->setHtmlHeader('<div style="text-align: right; width: 100%;">{PAGENO}</div>');
         $mpdf->WriteHTML($data2);
         $mpdf->Output('QrCode_'. $id .'_'. date('Y_m_d') .'.pdf', 'I');
    }

    public function history($id)
    {
         $data["titie"] = "ประวัติสินค้า";
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["users"] = User::with('Role')->get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = $this->menupos->getParentMenu();

         $data["products"] = Product::with('ProductStock')->find($id);
         return view('Admin.Product.list', $data);
    }
}
