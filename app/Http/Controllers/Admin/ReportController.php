<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\User;
use App\Models\Company;
use App\Models\Currency;

use App\Models\Transfer;
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

    // public function index()
    // {
    //      $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
    //      $data["menus"] = $this->menupos->getParentMenu();
    //      // $year = date("Y");
    //      // $date = date("Y-m-d");
    //      // $week = date("N", strtotime($date));//นับลำดับวันที่ในสัปดาห์สัปดาห์ เช่น วันที่ 1,2,3.....
    //      // $week1 = date("W", strtotime($date));//นับสัปดาห์ตามจริงของปี เช่นวันนี้เป็นสัปดาห์ที่ 16 ของปี 2014
    //      // //$start = date("Y-m-d",strtotime("-".($week-1)." days"));
    //      // //$end = date("Y-m-d",strtotime("+".(7-$week)." days"));
    //      // $date = new \DateTime();
    //      // $date->setISODate($year,$week1);
    //      // $start = $date->format("Y-m-d 23:59:59");
    //      // $date->setISODate($year,$week1,7);
    //      // $end = $date->format("Y-m-d 23:59:59");
    //      // $data["start_date"] = $start;
    //      // $data["end_date"] = $end;
    //
    //      // $data["orders"] = Order::where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
    //      $data["orders"] = Order::get();
    //
    //      return view('Admin.Report.index', $data);
    // }

    public function sales(Request $request)
    {
         $data["title"] = 'รายการขายทั้งหมด';
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         $data["companies"] = Company::where('use_flag', 'Y')->get();
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();
         if ($request->daterange){
              $daterange = $request->daterange;
              $str_date = explode('-', $daterange);
              $start_date = trim($str_date[0]);
              $end_date = trim($str_date[1]);
              $company_id = $request->company_id;
              $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
              $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company')->where('created_at', '>=', $start_date)
                                  ->where('created_at', '<=', $end_date)
                                  ->where('status', '=', 'S')
                                  ->where('company_id', '=', $company_id)
                                  ->get();
         }else{
              $year = date("Y");
              $date = date("Y-m-d");
              $week = date("N", strtotime($date));//นับลำดับวันที่ในสัปดาห์สัปดาห์ เช่น วันที่ 1,2,3.....
              $week1 = date("W", strtotime($date));//นับสัปดาห์ตามจริงของปี เช่นวันนี้เป็นสัปดาห์ที่ 16 ของปี 2014
              //$start = date("Y-m-d",strtotime("-".($week-1)." days"));
              //$end = date("Y-m-d",strtotime("+".(7-$week)." days"));
              $date = new \DateTime();
              $date->setISODate($year,$week1);
              $start = $date->format("Y-m-d 00:00:00");
              $date->setISODate($year,$week1,7);
              $end = $date->format("Y-m-d 23:59:59");
              $data["start_date"] = $start;
              $data["end_date"] = $end;
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company')
                                   ->where('created_at', '>=', $start)
                                  ->where('created_at', '<=', $end)
                                  ->where('status', '=', 'S')
                                  ->get();
         }
         return view('Admin.Report.sales', $data);
    }

    public function collection(Request $request)
    {
         $data["title"] = 'รายการขายและค่าบริการ';
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         $data["companies"] = Company::where('use_flag', 'Y')->get();
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();
         if ($request->daterange){
              $daterange = $request->daterange;
              $str_date = explode('-', $daterange);
              $start_date = trim($str_date[0]);
              $end_date = trim($str_date[1]);
              $company_id = $request->company_id;
              $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
              $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company')->where('created_at', '>=', $start_date)
                                  ->where('created_at', '<=', $end_date)
                                  ->where('status', '=', 'S')
                                  ->where('company_id', '=', $company_id)
                                  ->get();
         }else{
              $year = date("Y");
              $date = date("Y-m-d");
              $week = date("N", strtotime($date));
              $week1 = date("W", strtotime($date));
              $date = new \DateTime();
              $date->setISODate($year,$week1);
              $start = $date->format("Y-m-d 00:00:00");
              $date->setISODate($year,$week1,7);
              $end = $date->format("Y-m-d 23:59:59");
              $data["start_date"] = $start;
              $data["end_date"] = $end;
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company')
                                   ->where('created_at', '>=', $start)
                                  ->where('created_at', '<=', $end)
                                  ->where('status', '=', 'S')
                                  ->get();
         }
         return view('Admin.Report.collection', $data);
    }

    public function stock(Request $request)
    {
         $data["title"] = 'สินค้าที่ขายไป';
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         $data["companies"] = Company::where('use_flag', 'Y')->get();
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();
         if ($request->daterange){
              $daterange = $request->daterange;
              $str_date = explode('-', $daterange);
              $start_date = trim($str_date[0]);
              $end_date = trim($str_date[1]);
              $company_id = $request->company_id;
              $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
              $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company')->where('created_at', '>=', $start_date)
                                  ->where('created_at', '<=', $end_date)
                                  ->where('status', '=', 'S')
                                  ->where('company_id', '=', $company_id)
                                  ->get();
         }else{
              $year = date("Y");
              $date = date("Y-m-d");
              $week = date("N", strtotime($date));
              $week1 = date("W", strtotime($date));
              $date = new \DateTime();
              $date->setISODate($year,$week1);
              $start = $date->format("Y-m-d 00:00:00");
              $date->setISODate($year,$week1,7);
              $end = $date->format("Y-m-d 23:59:59");
              $data["start_date"] = $start;
              $data["end_date"] = $end;
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company')
                                   ->where('created_at', '>=', $start)
                                  ->where('created_at', '<=', $end)
                                  ->where('status', '=', 'S')
                                  ->get();
         }
         return view('Admin.Report.stock', $data);
    }

    public function salescashier()
    {

    }

    public function collectioncashier()
    {

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
