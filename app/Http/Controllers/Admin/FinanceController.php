<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Currency;
use App\Models\Transfer;
use App\Models\Company;
use App\Models\Order;
use App\User;
use Validator;
use Storage;
use App\Repositories\MenuRepository;

class FinanceController extends Controller
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

     public function index(Request $request)
     {
          if ($request->daterange) {
               $daterange = $request->daterange;
               $docuno = $request->docuno;
               $str_date = explode('-', $daterange);
               $start_date = self::ConvertDate($str_date[0]);
               $end_date = self::ConvertDate($str_date[1]);
               $data["daterange"] = date_format(date_create($start_date), "d M Y") . ' - ' . date_format(date_create($end_date), "d M Y");

          } else {
               if($request->daterange == null){
                    $end_date = date("Ymd");
                    $start_date = date('Ymd',strtotime($end_date . "-15 days"));
                    $data["daterange"] = date_format(date_create($start_date), "d M Y") . ' - ' . date_format(date_create($end_date), "d M Y");
               }
          }
          $data["titie"] = "การเงิน";
          $data["user"] = $user = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::where('use_flag', 'Y')->get();
          $company_id = $user->company_id;
          if ($user->role_id == 1) {
               $companies = Company::with(['Order' => function($q) use ($start_date, $end_date){
                    $q->where("created_at", ">=", $start_date);
                    $q->where("created_at", "<=", $end_date);
                    $q->with(['UserOrder' => function($query_user){
                         $query_user->where('status', '=', 'S');
                    }]);
                    $q->with(['Transfer' => function ($query_transfer){
                         $query_transfer->where('status' ,'=', 'Y');
                    }]);
               }])->get();
          } else if ($user->role_id == 2) {

          } else if ($user->role_id == 3) {
               $companies = Company::with(['Order' => function($q) use ($start_date, $end_date){
                    $q->where("created_at", ">=", $start_date);
                    $q->where("created_at", "<=", $end_date);
                    $q->with(['UserOrder' => function($query_user){
                         $query_user->where('status', '=', 'T');
                    }]);
                    $q->with(['Transfer' => function ($query_transfer){
                         $query_transfer->where('status' ,'=', 'Y');
                         $query_transfer->with('User');
                    }]);
               }])->where('id', '=', $company_id)->get();
               // $orders = Order::with('UserOrder', 'Transfer')->where('company_id', '=', $company_id)->get();
          }
          $data["companies"] = $companies;
          // $data["transfers"] = Transfer::where('payee_id', '=', \Auth::guard('admin')->id())->get();;

          return view('Admin.Finance.index', $data);
     }

     function ConvertDate($daterange){
          try {
               if ($daterange){
                    $start_date = explode(' ', trim($daterange));
                    if($start_date[1] == 'Jan'){
                         $date_use = $start_date[2] . '01' . $start_date[0];
                    }elseif($start_date[1] == 'Feb'){
                         $date_use = $start_date[2] . '02' . $start_date[0];
                    }elseif($start_date[1] == 'Mar'){
                         $date_use = $start_date[2] . '03' . $start_date[0];
                    }elseif($start_date[1] == 'Apr'){
                         $date_use = $start_date[2] . '04' . $start_date[0];
                    }elseif($start_date[1] == 'May'){
                         $date_use = $start_date[2] . '05' . $start_date[0];
                    }elseif($start_date[1] == 'Jun'){
                         $date_use = $start_date[2] . '06' . $start_date[0];
                    }elseif($start_date[1] == 'Jul'){
                         $date_use = $start_date[2] . '07' . $start_date[0];
                    }elseif($start_date[1] == 'Aug'){
                         $date_use = $start_date[2] . '08' . $start_date[0];
                    }elseif($start_date[1] == 'Sep'){
                         $date_use = $start_date[2] . '09' . $start_date[0];
                    }elseif($start_date[1] == 'Oct'){
                         $date_use = $start_date[2] . '10' . $start_date[0];
                    }elseif($start_date[1] == 'Nov'){
                         $date_use = $start_date[2] . '11' . $start_date[0];
                    }elseif($start_date[1] == 'Dec'){
                         $date_use = $start_date[2] . '12' . $start_date[0];
                    }
               }
               return $date_use;
          } catch (\Exception $e) {
               return null;
          }
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
