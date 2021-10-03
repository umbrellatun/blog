<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\MenuRepository;
use App\Models\Box;
use App\User;
use Validator;

class PartnerController extends Controller
{
     public function __construct(MenuRepository $menupos)
     {
          $this->menupos = $menupos;
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
         $company_id = $user->company_id;

         $companies = [];
         if ($user->role_id == 3) {
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
         }
         $data["companies"] = $companies;
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
