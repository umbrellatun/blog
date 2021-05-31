<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Transfer;

use App\User;
use Validator;
use Storage;
use App\Repositories\MenuRepository;

class WalletController extends Controller
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
          $data["titie"] = "กระเป๋าเงินของฉัน";
          $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
          $data["menus"] = $this->menupos->getParentMenu();
          $data["currencies"] = Currency::get();
          if ($request->daterange){
               $daterange = $request->daterange;
               $str_date = explode('-', $daterange);
               $start_date = trim($str_date[0]);
               $end_date = trim($str_date[1]);
               $data["start_date"] = $start_date = (date_format(date_create($start_date), 'Y-m-d 00:00:00'));
               $data["end_date"] = $end_date = (date_format(date_create($end_date), 'Y-m-d 23:59:59'));
               $data["transfers"] = Transfer::where('created_at', '>=', $start_date)
                                             ->where('created_at', '<=', $end_date)
                                             ->where('payee_id', '=', \Auth::guard('admin')->id())
                                             ->get();
          }else{
               $data["start_date"] = '';
               $data["end_date"] = '';
               $data["transfers"] = Transfer::where('payee_id', '=', \Auth::guard('admin')->id())
                                             ->get();
          }



          return view('Admin.Wallet.index', $data);
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
