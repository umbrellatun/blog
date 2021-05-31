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
                    <h5>Dashboard</h5>
                 </div>
                 <div class="card-body">
                      <div class="row">
                           <div class="col-sm-12">
                                <div class="card">
                                     <div class="card-body">
                                          <h5 class="mb-3">รายรับของฉัน</h5>
                                          <div class="row">
                                               <!-- [ bootstrap-datetimepicker ] start -->
                                               <div class="col-md-12">
                                                    <div class="card">
                                                         <div class="card-body">
                                                              <input type="text" name="daterange" id="daterange" class="form-control" value="{{date_format(date_create($start_date), "d/M/Y")}} - {{date_format(date_create($end_date), "d/M/Y")}}" />
                                                              <button type="submit" id="searchPeriod" class="btn btn-primary mt-2"><i class="fas fa-search mr-2"></i>ค้นหา</button>
                                                         </div>
                                                    </div>
                                               </div>
                                               <!-- [ bootstrap-datetimepicker ] End -->
                                          </div>
            						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            							<li class="nav-item">
            								<a class="nav-link active" style="color: #FFF !important;" id="pills-income-tab" data-toggle="pill" href="#pills-income" role="tab" aria-controls="pills-income" aria-selected="true">ที่สำเร็จแล้ว</a>
            							</li>
            							<li class="nav-item">
            								<a class="nav-link" style="color: #FFF !important;" id="pills-waitAttachFile-tab" data-toggle="pill" href="#pills-waitAttachFile" role="tab" aria-controls="pills-waitAttachFile" aria-selected="true">รอแนบหลักฐานการโอน</a>
            							</li>
            						</ul>
            						<div class="tab-content" id="pills-tabContent">
                                             <div class="tab-pane fade show active" id="pills-income" role="tabpanel" aria-labelledby="pills-income-tab">
                                                  <div class="dt-responsive table-responsive">
                                                       <table id="table1" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                 <tr>
                                                                      <th class="border-top-0">Order NO.</th>
                                                                      <th class="border-top-0">บริษัท</th>
                                                                      <th class="border-top-0">ผู้ซื้อ</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมหยิบ(บาท)</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมแพ็ค(บาท)</th>
                                                                      <th class="border-top-0">ค่า COD (บาท)</th>
                                                                      <th class="border-top-0">ยอดที่เรียกเก็บลูกค้า</th>
                                                                      <th class="border-top-0">รวมราคากล่อง</th>
                                                                      <th class="border-top-0">ค่าขนส่ง</th>
                                                                      <th class="border-top-0">ส่วนลด</th>
                                                                      <th class="border-top-0">รวม</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody>
                                                                 @php
                                                                      $all_price_pick = 0;
                                                                      $all_price_pack = 0;
                                                                      $all_price_delivery = 0;
                                                                      $all_price_product = 0;
                                                                      $all_price_box = 0;
                                                                      $all_shipping_cost = 0;
                                                                      $all_discount = 0;
                                                                      $total = 0;
                                                                 @endphp
                                                                 @foreach ($orders as $order)
                                                                      @if ($order->status == 'S')
                                                                           <tr>
                                                                                <td>{{$order->order_no}}</td>
                                                                                <td>{{$order->Company->name}}</td>
                                                                                <td>{{$order->Customer->name}}</td>
                                                                                <td>{{$order->pick}}</td>
                                                                                <td>{{$order->pack}}</td>
                                                                                <td>{{$order->delivery}}</td>
                                                                                <td>{{($order->OrderProduct)->sum('price_bath')}}</td>
                                                                                <td>{{($order->OrderBoxs)->sum('price_bath')}}</td>
                                                                                <td>{{$order->shipping_cost}}</td>
                                                                                <td>{{ isset($order->discount) ? '-' . $order->discount : 0 }}</td>
                                                                                <td>{{ ($order->pick+$order->pack+$order->delivery+($order->OrderProduct)->sum('price_bath')+($order->OrderBoxs)->sum('price_bath')+$order->shipping_cost) - $order->discount }}</td>
                                                                           </tr>
                                                                           @php
                                                                           $all_price_pick += $order->pick;
                                                                           $all_price_pack += $order->pack;
                                                                           $all_price_delivery += $order->delivery;
                                                                           $all_price_product += ($order->OrderProduct)->sum('price_bath');
                                                                           $all_price_box += ($order->OrderBoxs)->sum('price_bath');
                                                                           $all_shipping_cost += $order->shipping_cost;
                                                                           $all_discount += $order->discount;
                                                                           $total =( $all_price_pick+$all_price_pack+$all_price_delivery+$all_price_product+$all_price_box+$all_shipping_cost)-$all_discount
                                                                           @endphp
                                                                      @endif
                                                                 @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                 <td colspan="3"></td>
                                                                 <td><span class="text-primary">{{$all_price_pick}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_pack}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_delivery}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_product}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_box}}</span></td>
                                                                 <td><span class="text-primary">{{$all_shipping_cost}}</span></td>
                                                                 <td><span class="text-danger">{{ ($all_discount > 0) ? '-' . $all_discount : 0 }}</span></td>
                                                                 <td><span class="text-success">{{$total}}</span></td>
                                                            </tfoot>
                                                       </table>
                                                  </div>
            							</div>
            							<div class="tab-pane fade show" id="pills-waitAttachFile" role="tabpanel" aria-labelledby="pills-waitAttachFile-tab">
                                                  <div class="dt-responsive table-responsive">
                                                       <table id="table2" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                 <tr>
                                                                      <th class="border-top-0">Order NO.</th>
                                                                      <th class="border-top-0">บริษัท</th>
                                                                      <th class="border-top-0">ผู้ซื้อ</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมหยิบ(บาท)</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมแพ็ค(บาท)</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมขนส่ง(บาท)</th>
                                                                      <th class="border-top-0">รวมราคาสินค้า</th>
                                                                      <th class="border-top-0">รวมราคากล่อง</th>
                                                                      <th class="border-top-0">ค่าขนส่ง</th>
                                                                      <th class="border-top-0">ส่วนลด</th>
                                                                      <th class="border-top-0">รวม</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody>
                                                                 @php
                                                                      $all_price_pick = 0;
                                                                      $all_price_pack = 0;
                                                                      $all_price_delivery = 0;
                                                                      $all_price_product = 0;
                                                                      $all_price_box = 0;
                                                                      $all_shipping_cost = 0;
                                                                      $all_discount = 0;
                                                                      $total = 0;
                                                                 @endphp
                                                                 @foreach ($orders as $order)
                                                                      @if ($order->status == 'W')
                                                                           <tr>
                                                                                <td>{{$order->order_no}}</td>
                                                                                <td>{{$order->Company->name}}</td>
                                                                                <td>{{$order->Customer->name}}</td>
                                                                                <td>{{$order->pick}}</td>
                                                                                <td>{{$order->pack}}</td>
                                                                                <td>{{$order->delivery}}</td>
                                                                                <td>{{($order->OrderProduct)->sum('price_bath')}}</td>
                                                                                <td>{{($order->OrderBoxs)->sum('price_bath')}}</td>
                                                                                <td>{{$order->shipping_cost}}</td>
                                                                                <td>{{ isset($order->discount) ? '-' . $order->discount : 0 }}</td>
                                                                                <td>{{ ($order->pick+$order->pack+$order->delivery+($order->OrderProduct)->sum('price_bath')+($order->OrderBoxs)->sum('price_bath')+$order->shipping_cost) - $order->discount }}</td>
                                                                           </tr>
                                                                           @php
                                                                           $all_price_pick += $order->pick;
                                                                           $all_price_pack += $order->pack;
                                                                           $all_price_delivery += $order->delivery;
                                                                           $all_price_product += ($order->OrderProduct)->sum('price_bath');
                                                                           $all_price_box += ($order->OrderBoxs)->sum('price_bath');
                                                                           $all_shipping_cost += $order->shipping_cost;
                                                                           $all_discount += $order->discount;
                                                                           $total =( $all_price_pick+$all_price_pack+$all_price_delivery+$all_price_product+$all_price_box+$all_shipping_cost)-$all_discount
                                                                           @endphp
                                                                      @endif
                                                                 @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                 <td colspan="3"></td>
                                                                 <td><span class="text-primary">{{$all_price_pick}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_pack}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_delivery}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_product}}</span></td>
                                                                 <td><span class="text-primary">{{$all_price_box}}</span></td>
                                                                 <td><span class="text-primary">{{$all_shipping_cost}}</span></td>
                                                                 <td><span class="text-danger">{{ ($all_discount > 0) ? '-' . $all_discount : 0 }}</span></td>
                                                                 <td><span class="text-success">{{$total}}</span></td>
                                                            </tfoot>
                                                       </table>
                                                  </div>
            							</div>
            						</div>
            					</div>
            				</div>
            			</div>
                      </div>
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

          // $('#searchPeriod').click(function(e){
          //      e.preventDefault();
          //      $("#table1").dataTable().fnClearTable();
          //      $("#table1").dataTable().fnDraw();
          //      $("#table1").dataTable().fnDestroy();
          //      $("#table2").dataTable().fnClearTable();
          //      $("#table2").dataTable().fnDraw();
          //      $("#table2").dataTable().fnDestroy();
          //
          //      $("#table1 tfoot").empty();
          //      $("#table2 tfoot").empty();
          //      $.ajax({
          //           method : "post",
          //           url : '{{ route('dashboard.searchPeriod') }}',
          //           dataType : 'json',
          //           data: {"daterange" : $("#daterange").val()},
          //           beforeSend: function() {
          //                $("#preloaders").css("display", "block");
          //           },
          //      }).done(function(rec){
          //           let column1 = '';
          //           let column2 = '';
          //           let column3 = '';
          //           let column4 = '';
          //           let column5 = '';
          //           let column6 = '';
          //           let column7 = '';
          //           let column8 = '';
          //           let column9 = '';
          //           let column10 = '';
          //           let column11 = '';
          //           $("#preloaders").css("display", "none");
          //           if (rec.orders.length > 0){
          //                $.each(rec.orders, function( key, data ) {
          //                     column1 = data.order_no;
          //                     column2 = data.company.name;
          //                     column3 = data.customer.name;
          //                     column4 = data.pick;
          //                     column5 = data.pack;
          //                     column6 = data.delivery;
          //                     column7 = data;
          //                     column8 = data;
          //                     column9 = data;
          //                     column10 = data;
          //                     column11 = data;
          //
          //                     $("#table1").DataTable().row.add([column1, column2, column3, column4, column5, column6, column7]).draw();
          //                     column1 = '';
          //                     column2 = '';
          //                     column3 = '';
          //                     column4 = '';
          //                     column5 = '';
          //                     column6 = '';
          //                     column7 = '';
          //                     column8 = '';
          //                     column9 = '';
          //                     column10 = '';
          //                     column11 = '';
          //                });
          //           }
          //
          //      }).fail(function(){
          //           $("#preloaders").css("display", "none");
          //           swal("", rec.content, "error");
          //      });
          // });

     });
     </script>
@endsection
