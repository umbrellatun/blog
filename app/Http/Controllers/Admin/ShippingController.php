<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Shipping;
use App\Models\ShippingOrder;
use App\Models\Order;
use App\Models\Currency;
use App\User;

use Validator;
use App\Repositories\MenuRepository;

class ShippingController extends Controller
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
    public function index($id)
    {
         $shipping = Shipping::find($id);
         $data["titie"] = $shipping->name;
         $data["menus"] = $this->menupos->getParentMenu();
         $data["user"] = User::with('Role')->find(\Auth::guard('admin')->id());
         $data["currencies"] = Currency::where('use_flag', 'Y')->get();

         // $data["shippings"] = Shipping::with('ShippingOrder.Order.OrderProduct.Product')
         //                                ->with('ShippingOrder.Order.OrderBoxs.Box')
         //                                ->find($id);

         $shipping_orders = ShippingOrder::where('status', 'S')->where('shipping_id', $id)->get();

         $order_arr = [];
         foreach ($shipping_orders as $key => $shipping_order) {
              array_push($order_arr, $shipping_order->order_id);
         }

         $data["orders"] = Order::with(['OrderBoxs', 'OrderProduct'])->whereIn('id', $order_arr)->get();



         return view('Admin.Shipping.list', $data);
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
