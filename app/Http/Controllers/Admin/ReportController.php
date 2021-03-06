<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\User;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Product;

use App\Models\Transfer;
use App\Repositories\MenuRepository;
use Validator;
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

              $data["products"] = Product::with('Company')->with(['OrderProduct' => function($q)use($start_date, $end_date){
                  $q->where('created_at', '>=', $start_date);
                  $q->where('created_at', '<=', $end_date);
                  $q->where('status', 'S');
                  $q->with('Order');
             }])->where('company_id', '=', $company_id)->get();
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
              $data["products"] = Product::with('Company')->with(['OrderProduct' => function($q)use($start, $end){
                   $q->where('created_at', '>=', $start);
                   $q->where('created_at', '<=', $end);
                   $q->where('status', 'S');
                   $q->with('Order');
              }])->get();
         }
         return view('Admin.Report.stock', $data);
    }

    public function salescashier(Request $request)
    {
         $data["title"] = 'รายงานการขาย Admin';
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         $data["companies"] = Company::where('use_flag', 'Y')->get();
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();
         if ($request->daterange || $request->company_id || $request->user_id){
              $daterange = $request->daterange;
              $str_date = explode('-', $daterange);
              $start_date = trim($str_date[0]);
              $end_date = trim($str_date[1]);
              $company_id = $request->company_id;
              $user_id = $request->user_id;
              $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
              $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
              $data["users"] = User::where('company_id', '=', $company_id)->get();
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company', 'CreatedBy')
                                        ->where('created_at', '>=', $start_date)
                                        ->where('created_at', '<=', $end_date)
                                        ->where('status', '=', 'S')
                                        ->where('company_id', '=', $company_id)
                                        ->where('created_by', '=', $user_id)
                                        ->get();
         } else {
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
         return view('Admin.Report.salescashier', $data);
    }

    public function get_member(Request $request)
    {
         $company_id = $request->company_id;
         $validator = Validator::make($request->all(), [

         ]);
         if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                   $users = User::where('company_id', '=', $company_id)->get();
                   $return["users"] = $users;
                   $return['status'] = 1;
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

    public function collectioncashier(Request $request)
    {
         $data["title"] = 'รายงานปิดงานแล้ว COD';
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         $data["companies"] = Company::where('use_flag', 'Y')->get();
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();
         if ($request->daterange || $request->company_id || $request->user_id){
              $daterange = $request->daterange;
              $str_date = explode('-', $daterange);
              $start_date = trim($str_date[0]);
              $end_date = trim($str_date[1]);
              $company_id = $request->company_id;
              $user_id = $request->user_id;
              $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
              $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
              $data["users"] = User::where('company_id', '=', $company_id)->get();
              $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company', 'CreatedBy')
                                        ->where('created_at', '>=', $start_date)
                                        ->where('created_at', '<=', $end_date)
                                        ->where('status', '=', 'S')
                                        ->where('company_id', '=', $company_id)
                                        ->where('created_by', '=', $user_id)
                                        ->get();
         } else {
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
         return view('Admin.Report.collectioncashier', $data);
    }

    public function product(Request $request)
    {
         $data["title"] = 'รายงานสินค้าปิดงานแล้ว';
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["menus"] = $this->menupos->getParentMenu();
         $data["companies"] = Company::where('use_flag', 'Y')->get();
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();
         if ($request->daterange || $request->company_id || $request->user_id){
              $daterange = $request->daterange;
              $str_date = explode('-', $daterange);
              $start_date = trim($str_date[0]);
              $end_date = trim($str_date[1]);
              $company_id = $request->company_id;
              $user_id = $request->user_id;
              $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
              $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
              $data["users"] = User::where('company_id', '=', $company_id)->get();
              $data["products"] = Product::with('Company')->with(['OrderProduct' => function($q)use($start_date, $end_date, $user_id){
                  $q->where('created_at', '>=', $start_date);
                  $q->where('created_at', '<=', $end_date);
                  $q->where('created_by', '<=', $user_id);
                  $q->where('status', 'S');
                  $q->with('Order');
                  $q->with('CreatedBy');
             }])->where('company_id', '=', $company_id)->where('created_by', '=', $user_id)->get();
         } else {
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
              $data["products"] = [];
              // $data["orders"] = Order::with('OrderProduct', 'OrderBoxs', 'Company')
              //                      ->where('created_at', '>=', $start)
              //                     ->where('created_at', '<=', $end)
              //                     ->where('status', '=', 'S')
              //                     ->get();
         }
         return view('Admin.Report.product', $data);
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
