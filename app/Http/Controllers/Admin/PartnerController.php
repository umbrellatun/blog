<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\MenuRepository;
use App\Models\Box;
use App\Models\Currency;
use App\Models\PartnerOrder;
use App\User;
use Validator;

class PartnerController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
         $start_date = date_create($start_date);
         $start_date = date_format($start_date,"Y-m-d H:i:s");
         $end_date = date_create($end_date);
         $end_date = date_format($end_date,"Y-m-d 23:59:59");
         $data["titie"] = "Partner";
         $data["menus"] = $this->menupos->getParentMenu();
         $data["user"] = $user = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();
         $company_id = $user->company_id;

         // dd();
         $companies = [];
         $partners = PartnerOrder::with('Order.OrderProduct')
                                   ->with('Order.OrderBoxs')
                                   ->where('created_at', '>=', $start_date)
                                   ->where('created_at', '<=', $end_date)
                                   ->where('company_id', $user->company_id)
                                   ->get();

         $data["companies"] = $companies;
         $data["partners"] = $partners;
        return view('Admin.Partner.index', $data);
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
