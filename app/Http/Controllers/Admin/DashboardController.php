<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\User;
use App\Models\Company;
use App\Repositories\MenuRepository;

class DashboardController extends Controller
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
          $data["menus"] = $this->menupos->getParentMenu();
          $data["orders"] = Order::with(['Customer', 'Company', 'OrderProduct', 'OrderBoxs'])->get();

          return view('Admin.Dashboard.index', $data);
     }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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

     public function orderStatus($orderStatus)
     {
          if ($orderStatus == 'W') {
               $title = 'รอแนบหลักฐานการโอน';
          } elseif($orderStatus == 'WA'){
               $title = 'ตรวจสอบหลักฐานการโอนแล้ว รอแพ็ค';
          } elseif($orderStatus == 'P'){
               $title = 'แพ็คสินค้าแล้ว อยู่ระหว่างจัดส่ง';
          } elseif($orderStatus == 'T'){
               $title = 'จัดส่งแล้ว รอปรับสถานะ';
          } elseif($orderStatus == 'S'){
               $title = 'เสร็จสมบูรณ์';
          } elseif($orderStatus == 'C'){
               $title = 'Cancel';
          }
          $data["titie"] = $title;
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["companies"] = Company::where('use_flag', '=', 'Y')->get();
          $data["menus"] = $this->menupos->getParentMenu();

          $data["orders"] = Order::with(['Customer', 'Shipping', 'OrderProduct', 'OrderBoxs'])->where('status', '=', $orderStatus)->get();
          return view('Admin.Order.list', $data);
     }
}
