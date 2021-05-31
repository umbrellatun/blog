<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\User;
use App\Models\Company;
use App\Repositories\MenuRepository;

class ReportController extends Controller
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
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         // $year = date("Y");
         // $date = date("Y-m-d");
         // $week = date("N", strtotime($date));//นับลำดับวันที่ในสัปดาห์สัปดาห์ เช่น วันที่ 1,2,3.....
         // $week1 = date("W", strtotime($date));//นับสัปดาห์ตามจริงของปี เช่นวันนี้เป็นสัปดาห์ที่ 16 ของปี 2014
         // //$start = date("Y-m-d",strtotime("-".($week-1)." days"));
         // //$end = date("Y-m-d",strtotime("+".(7-$week)." days"));
         // $date = new \DateTime();
         // $date->setISODate($year,$week1);
         // $start = $date->format("Y-m-d 23:59:59");
         // $date->setISODate($year,$week1,7);
         // $end = $date->format("Y-m-d 23:59:59");
         // $data["start_date"] = $start;
         // $data["end_date"] = $end;

         // $data["orders"] = Order::where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
         $data["orders"] = Order::get();

         return view('Admin.Report.index', $data);
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
        //
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
