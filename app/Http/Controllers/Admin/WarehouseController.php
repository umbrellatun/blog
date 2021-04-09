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
use \Mpdf\Mpdf;

class WarehouseController extends Controller
{
    public function index()
    {
         $data["titie"] = "รับสินค้าเข้าโกดัง";
         $data["users"] = User::with('Role')->get();
         $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
         $data["menus"] = Menu::with('SubMenu')->orderBy('sort', 'asc')->get();
         $data["products"] = Product::where('use_flag', '=', 'Y')->get();
         return view('Admin.Product.warehouse', $data);
    }

    public function getqrcode(Request $request)
    {
        $sku = $request->data;
        $product = Product::with('ProductType', 'Company')->where('sku', '=', $sku)->first();
        return json_encode($product);
    }

    public function store(Request $request)
    {
         $product_id = $request->product_id;
         $qty = $request->qty;
         $validator = Validator::make($request->all(), [
              'product_id' => 'required',
              'qty' => 'required'
         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $product = Product::find($product_id);
                   $total = (!isset($product->in_stock) ? 0 : $product->in_stock) + intval($qty);
                   $data = [
                        'in_stock' => $total
                        ,'updated_by' => \Auth::guard('admin')->id()
                        ,'updated_at' => date('Y-m-d H:i:s')
                   ];
                   Product::where('id', '=', $product_id)->update($data);

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
