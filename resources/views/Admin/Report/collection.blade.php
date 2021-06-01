@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
          <div class="col-sm-12">
               <div class="card">
                    <div class="card-header">
                         <h5>{{$title}}</h5>
                    </div>
                    <div class="card-body">
                         <div class="row">
                              <div class="col-md-12">
                                   <form action="{{ route('report.sales') }}" method="GET" role="search">
                                        <div class="form-group">
                                             <label class="form-label">บริษัท</label>
                                             <select class="form-control" name="company_id" id="company_id">
                                                  <option value>กรุณาเลือก</option>
                                                  @foreach ($companies as $company)
                                                       <option value="{{$company->id}}">{{$company->name}}</option>
                                                  @endforeach
                                             </select>
                                        </div>
                                        <div class="form-group">
                                             <label class="form-label">ช่วงวันที่</label>
                                             @if (empty($start_date))
                                                  <input type="text" name="daterange" id="daterange" class="form-control" value="" placeholder="กรุณาระบุช่วงเวลา" autocomplete="off" />
                                             @else
                                                  <input type="text" name="daterange" id="daterange" class="form-control" value="{{ date_format(date_create($start_date), "d/M/Y")}} - {{date_format(date_create($end_date), "d/M/Y")}}" />
                                             @endif
                                             <button type="submit" id="searchPeriod" class="btn btn-primary mt-2"><i class="fas fa-search mr-2"></i>ค้นหา</button>
                                        </div>
                                   </form>
                              </div>
                         </div>
                         @foreach ($currencies as $currency)
                             <div class="card">
                                  <div class="card-header">
                                       <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 25px;">
                                       <h5>{{$currency->name}}</h5>
                                  </div>
                                  <div class="card-body">
                                       <div class="dt-responsive table-responsive">
                                            <table id="table{{$currency->id}}" class="table table-striped table-bordered nowrap">
                                                 <thead>
                                                      <tr>
                                                           <th class="border-top-0">No.</th>
                                                           <th class="border-top-0">Company</th>
                                                           <th class="border-top-0">Order Date</th>
                                                           <th class="border-top-0">Order No</th>
                                                           <th class="border-top-0">COD</th>
                                                           <th class="border-top-0">Customer Name</th>
                                                           <th class="border-top-0">Customer Mobile No.</th>
                                                           <th class="text-center border-top-0">ค่าสินค้า</th>
                                                           <th class="text-center border-top-0">ค่ากล่อง</th>
                                                           <th class="text-center border-top-0">ค่าขนส่ง</th>
                                                           <th class="text-center border-top-0">ส่วนลด</th>
                                                           <th class="text-center border-top-0">ค่าหยิบ</th>
                                                           <th class="text-center border-top-0">ค่าแพ็ค</th>
                                                           <th class="text-center border-top-0">ค่าCOD</th>
                                                           <th class="text-center border-top-0">รวมราคา</th>
                                                      </tr>
                                                 </thead>
                                                 <tbody>
                                                      @php
                                                      $i = 1;
                                                      $total_order_product = 0;
                                                      $total_order_box = 0;
                                                      $total_shipping_cost = 0;
                                                      $total_discount = 0;
                                                      $total_pick = 0;
                                                      $total_pack = 0;
                                                      $total_delivery = 0;
                                                      $total_all = 0;
                                                      @endphp
                                                      @foreach ($orders->where('currency_id', '=', $currency->id) as $order)
                                                           <tr>
                                                                <td>{{$i}}</td>
                                                                <td>{{ $order->Company->name }}</td>
                                                                <td>{{ date_format($order->created_at, 'd M Y') }}</td>
                                                                <td>{{ $order->order_no }}</td>
                                                                <td>{{ isset($order->delivery) ? 'Yes' : 'No' }}</td>
                                                                <td>{{ $order->customer_name }}</td>
                                                                <td>{{ $order->customer_phone_number }}</td>
                                                                @if ($currency->id == 1)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_bath'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderBoxs->sum('price_bath'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->shipping_cost, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->discount, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pick, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pack, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->delivery, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_bath') + $order->OrderBoxs->sum('price_bath') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery, 2) }}</td>
                                                                     @php
                                                                          $total_order_product = $total_order_product + $order->OrderProduct->sum('price_bath');
                                                                          $total_order_box = $total_order_box + $order->OrderBoxs->sum('price_bath');
                                                                          $total_shipping_cost = $total_shipping_cost + $order->shipping_cost;
                                                                          $total_discount = $total_discount + $order->discount;
                                                                          $total_pick = $total_pick + $order->pick;
                                                                          $total_pack = $total_pack + $order->pack;
                                                                          $total_delivery = $total_delivery + $order->delivery;
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_bath') + $order->OrderBoxs->sum('price_bath') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery);
                                                                     @endphp
                                                                @elseif ($currency->id == 2)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_lak'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderBoxs->sum('price_lak'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->shipping_cost, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->discount, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pick, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pack, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->delivery, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_lak') + $order->OrderBoxs->sum('price_lak') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery, 2) }}</td>
                                                                     @php
                                                                          $total_order_product = $total_order_product + $order->OrderProduct->sum('price_lak');
                                                                          $total_order_box = $total_order_box + $order->OrderBoxs->sum('price_lak');
                                                                          $total_shipping_cost = $total_shipping_cost + $order->shipping_cost;
                                                                          $total_discount = $total_discount + $order->discount;
                                                                          $total_pick = $total_pick + $order->pick;
                                                                          $total_pack = $total_pack + $order->pack;
                                                                          $total_delivery = $total_delivery + $order->delivery;
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_lak') + $order->OrderBoxs->sum('price_lak') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery);
                                                                     @endphp
                                                                @elseif ($currency->id == 3)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_usd'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderBoxs->sum('price_usd'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->shipping_cost, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->discount, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pick, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pack, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->delivery, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_usd') + $order->OrderBoxs->sum('price_usd') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery, 2) }}</td>
                                                                     @php
                                                                          $total_order_product = $total_order_product + $order->OrderProduct->sum('price_usd');
                                                                          $total_order_box = $total_order_box + $order->OrderBoxs->sum('price_usd');
                                                                          $total_shipping_cost = $total_shipping_cost + $order->shipping_cost;
                                                                          $total_discount = $total_discount + $order->discount;
                                                                          $total_pick = $total_pick + $order->pick;
                                                                          $total_pack = $total_pack + $order->pack;
                                                                          $total_delivery = $total_delivery + $order->delivery;
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_usd') + $order->OrderBoxs->sum('price_usd') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery);
                                                                     @endphp
                                                                @elseif ($currency->id == 4)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_khr'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderBoxs->sum('price_khr'), 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->shipping_cost, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->discount, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pick, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->pack, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->delivery, 2) }}</td>
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_khr') + $order->OrderBoxs->sum('price_khr') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery, 2) }}</td>
                                                                     @php
                                                                          $total_order_product = $total_order_product + $order->OrderProduct->sum('price_khr');
                                                                          $total_order_box = $total_order_box + $order->OrderBoxs->sum('price_khr');
                                                                          $total_shipping_cost = $total_shipping_cost + $order->shipping_cost;
                                                                          $total_discount = $total_discount + $order->discount;
                                                                          $total_pick = $total_pick + $order->pick;
                                                                          $total_pack = $total_pack + $order->pack;
                                                                          $total_delivery = $total_delivery + $order->delivery;
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_khr') + $order->OrderBoxs->sum('price_khr') + $order->shipping_cost - $order->discount + $order->pick + $order->pack + $order->delivery);
                                                                     @endphp
                                                                @endif
                                                           </tr>
                                                           @php
                                                           $i++;
                                                           @endphp
                                                      @endforeach
                                                 </tbody>
                                                 <tfoot>
                                                      <tr>
                                                           <td colspan="7"></td>
                                                           <td class="text-right">{{ number_format($total_order_product, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_order_box, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_shipping_cost, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_pick, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_pack, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_delivery, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_all, 2) }}</td>
                                                      </tr>
                                                 </tfoot>
                                            </table>
                                       </div>
                                  </div>
                             </div>
                        @endforeach
                    </div>
               </div>
          </div>
     </div>
@endsection
@section('modal')

@endsection
@section('js_bottom')
     <!-- datatable Js -->
     <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>

     <!-- datepicker js -->
     <script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>

     <script type="text/javascript">
     $(document).ready(function() {

          $(function() {
               $('input[name="daterange"]').daterangepicker({
                    locale: {
                         format: 'DD MMM YYYY'
                    },

                    opens: 'left'
               }, function(start, end, label) {

               });
          });

          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });


     });
     </script>
@endsection
