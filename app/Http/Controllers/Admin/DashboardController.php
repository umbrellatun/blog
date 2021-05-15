<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;

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
     public function finance()
     {
          $data["menus"] = $this->menupos->getParentMenu();

          $year = date("Y");
          $date = date("Y-m-d");
          $week = date("N", strtotime($date));//นับลำดับวันที่ในสัปดาห์สัปดาห์ เช่น วันที่ 1,2,3.....
          $week1 = date("W", strtotime($date));//นับสัปดาห์ตามจริงของปี เช่นวันนี้เป็นสัปดาห์ที่ 16 ของปี 2014
          //$start = date("Y-m-d",strtotime("-".($week-1)." days"));
          //$end = date("Y-m-d",strtotime("+".(7-$week)." days"));
          $date = new \DateTime();
          $date->setISODate($year,$week1);
          $start = $date->format("Y-m-d");
          $date->setISODate($year,$week1,7);
          $end = $date->format("Y-m-d");

          $data["start_date"] = $start;
          $data["end_date"] = $end;

          $data["orders"] = Order::where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
          return view('Admin.Dashboard.finance', $data);
     }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function searchPeriod(Request $request)
     {
          $daterange = explode('-', $request->daterange);
          $start = trim($daterange[0]);
          $end = trim($daterange[1]);
          $start = date_format(date_create($start), 'Y-m-d');
          $end = date_format(date_create($end), 'Y-m-d');
          $data["orders"] = $orders = Order::with(['Customer', 'Company'])
          ->with(['OrderProduct'])
          ->with(['OrderBoxs'])
          ->where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
          return json_encode($data);
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
