@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
         <div class="col-12">
             <div class="card">
                 <div class="card-header">
                    <h5>{{$titie}}</h5>
                 </div>
                 <div class="card-body">
                      <div class="row">
                           <div class="col-12">
                                <form action="" method="GET">
                                     <div class="form-group">
                                          <label>วันที่เอกสาร</label>
                                          <input type="text" name="daterange" autocomplete="off" class="form-control w-50" value="{{ isset($_GET["daterange"]) ? $_GET["daterange"] : $daterange }}" />
                                     </div>
                                     <div class="form-group">
                                          <input type="submit" class="btn btn-primary" value="Search">
                                     </div>
                                </form>
                           </div>
                      </div>
                      <div class="row">
                           <div class="col-12">
                                @foreach ($companies as $company)
                                    <div class="card bg-white">
                                         <div class="card-header">
                                              <h5>{{$company->name}}</h5>
                                         </div>
                                         <div class="card-body">
                                              <div class="col-12">
                                                   <div class="row">
                                                        @foreach ($currencies as $currency)
                                                             <div class="col-6">
                                                                  <div class="card analytic-card {{$currency->bgcolor}}">
                                                                       <div class="card-body">
                                                                            <div class="row align-items-center m-b-25">
                                                                                 <div class="col-auto">
                                                                                      <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 50px;">
                                                                                 </div>
                                                                                 <div class="col text-right">
                                                                                      @php
                                                                                           $sum_thb = 0;
                                                                                           $sum_lak = 0;
                                                                                      @endphp
                                                                                      @foreach ($company->Order as $order)
                                                                                         @if ($order->currency_id == 1)
                                                                                              @if ($order->UserOrder)
                                                                                                   @php

                                                                                                       $sum_thb = $sum_thb + $order->UserOrder->receive_money_thb;
                                                                                                  @endphp
                                                                                              @endif
                                                                                         @endif
                                                                                         @if ($order->currency_id == 2)
                                                                                              @if ($order->UserOrder)
                                                                                                   @php
                                                                                                       $sum_lak = $sum_lak + $order->UserOrder->receive_money_lak;
                                                                                                  @endphp
                                                                                              @endif
                                                                                         @endif
                                                                                      @endforeach
                                                                                      <h3 class="m-b-5 text-white">{{ ($currency->id == 1 ? number_format($sum_thb) : number_format($sum_lak)) }}</h3>
                                                                                      <h6 class="m-b-0 text-white">{{ $currency->name }}</h6>
                                                                                 </div>
                                                                            </div>
                                                                            <h5 class="text-white d-inline-block m-b-0 m-l-10">{{$currency->name_th}}</h5>
                                                                            {{-- <p class="m-b-0 text-white d-inline-block">Total Revenue : </p> --}}
                                                                            {{-- <i class="fas fa-caret-up m-r-10 f-18"></i> --}}
                                                                            <h6 class="m-b-0 d-inline-block text-white float-right">ยอดเก็บเงินปลายทาง</h6>
                                                                       </div>
                                                                  </div>
                                                             </div>
                                                        @endforeach
                                                   </div>
                                                   <div class="card">
                                                         <div class="card-body">
                                                              <div class="dt-responsive table-responsive">
                                                                   <table class="table nowrap">
                                                                        {{-- cod-list-table  --}}
                                                                        <thead>
                                                                            <tr>
                                                                                 <th class="text-left">Order NO.</th>
                                                                                 <th class="text-left">วันที่สร้าง Order</th>
                                                                                 <th class="text-center">โอนเล้ว(THB)</th>
                                                                                 <th class="text-center">โอนเล้ว(LAK)</th>
                                                                                 <th class="text-center">เก็บเงินปลายทาง (THB)</th>
                                                                                 <th class="text-center">เก็บเงินปลายทาง (LAK)</th>
                                                                                 <th class="text-center">วันเวลาที่โอนเงิน</th>
                                                                                 <th class="text-center">โอนเงินโดย</th>
                                                                                 <th class="text-center">หมายเหตุ</th>
                                                                            </tr>
                                                                       </thead>
                                                                       <tbody>
                                                                            @php
                                                                                 $i = 1;
                                                                            @endphp
                                                                            @foreach ($company->Order as $order)
                                                                                 @if (isset($order->UserOrder))
                                                                                      @php
                                                                                           $amount_thb = 0;
                                                                                           $amount_lak = 0;
                                                                                      @endphp
                                                                                      @if ($order->Transfer)
                                                                                           @foreach ($order->Transfer as $key => $Transfer)
                                                                                                @if ($Transfer->currency_id == 1)
                                                                                                     @php
                                                                                                          $amount_thb = $amount_thb + $Transfer->amount;
                                                                                                     @endphp
                                                                                                @endif
                                                                                                @if ($Transfer->currency_id == 2)
                                                                                                     @php
                                                                                                          $amount_lak = $amount_lak + $Transfer->amount;
                                                                                                     @endphp
                                                                                                @endif
                                                                                           @endforeach
                                                                                      @endif
                                                                                      <tr>
                                                                                           <td class="text-left">{{$order->order_no}}</td>
                                                                                           <td class="text-left">{{$order->created_at}}</td>
                                                                                           <td class="text-right">{{ number_format($amount_thb) }}</td>
                                                                                           <td class="text-right">{{ number_format($amount_lak) }}</td>
                                                                                           <td class="text-right">{{ number_format($order->UserOrder->receive_money_thb) }}</td>
                                                                                           <td class="text-right">{{ number_format($order->UserOrder->receive_money_lak) }}</td>
                                                                                           <td class="text-center">{{$order->UserOrder->transfer_date}}</td>
                                                                                           <td class="text-center">{{$order->UserOrder->transfer_by}}</td>
                                                                                           <td class="text-center">{{$order->UserOrder->remark}}</td>
                                                                                      </tr>
                                                                                 @endif
                                                                            @endforeach
                                                                       </tbody>
                                                                   </table>
                                                              </div>
                                                         </div>
                                                    </div>
                                              </div>
                                         </div>
                                    </div>
                               @endforeach
                           </div>
                      </div>



                      {{-- @foreach ($currencies as $currency)
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
                                                         <th class="border-top-0">ชื่อไฟล์</th>
                                                         <th class="border-top-0">จำนวนเงิน</th>
                                                         <th class="border-top-0">วันที่โอน</th>
                                                         <th class="border-top-0">เวลาโอน</th>
                                                         <th class="border-top-0">หมายเหตุ</th>
                                                         <th class="border-top-0">สถานะ</th>
                                                         <th class="border-top-0">ผู้รับเงิน</th>
                                                         <th class="border-top-0">action</th>
                                                    </tr>
                                               </thead>
                                               <tbody>
                                                    @php
                                                    $i = 1;
                                                    @endphp
                                                    @foreach ($transfers->where('currency_id', '=', $currency->id) as $transfer)
                                                         <tr>
                                                              <td>{{$i}}</td>
                                                              <td>{{$transfer->image}}</td>
                                                              <td>{{ number_format($transfer->amount, 2) }}</td>
                                                              <td>{{$transfer->transfer_date}}</td>
                                                              <td>{{$transfer->transfer_hours}}:{{$transfer->transfer_minutes}}</td>
                                                              <td>{{( strlen($transfer->remark) > 0 ? $transfer->remark : '-')}}</td>
                                                              <td>
                                                                   {{ ($transfer->status == 'W') ? 'รออนุมัติ' : 'อนุมัติแล้ว' }}
                                                              </td>
                                                              <td>{{ $transfer->User->name }} {{ $transfer->User->lastname }}</td>
                                                              <td>
                                                                   <div class="btn-group btn-group-sm">
                                                                        <button type="button" class="btn btn-success btn-view" data-toggle="modal" data-value="{{$transfer->id}}">
                                                                             <i class="fa fa-eye"></i>
                                                                        </button>
                                                                   </div>
                                                              </td>
                                                         </tr>
                                                         @php
                                                         $i++;
                                                         @endphp
                                                    @endforeach
                                               </tbody>
                                               <tfoot>
                                                    <tr>
                                                         <td colspan="2"></td>
                                                         <td>{{ (isset($transfer) ? number_format($transfer->where('currency_id', '=', $currency->id)->sum('amount'), 2) : '')}}</td>
                                                         <td colspan="6"></td>
                                                    </tr>
                                               </tfoot>
                                          </table>
                                     </div>
                                </div>
                           </div>
                      @endforeach --}}
                 </div>
             </div>
         </div>
     </div>
@endsection
@section('modal')
     <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-body text-center">
                         <img src="{{asset('assets/images/product/prod-0.jpg')}}" id="transfer_slip_img" style=" height: 400px; width: 300px;"></img>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-danger btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                         {{-- <button type="button" class="btn  btn-primary">Save changes</button> --}}
                    </div>
               </div>
          </div>
     </div>
@endsection
@section('js_bottom')
     <!-- datatable Js -->
     <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>

     <!-- daterangepicker -->
     <script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>

     <script type="text/javascript">
     $('.cod-list-table').DataTable();
     $('#transfer-list-table').DataTable();
     $(function() {
          $('input[name="daterange"]').daterangepicker({
               locale: {
                    format: 'DD MMM YYYY'
               },
               opens: 'left'
          }, function(start, end, label) {

          });

          $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
               $(this).val('');
          });

     });

     $(document).ready(function() {
          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });


          $('body').on('click','.btn-view',function(e){
               e.preventDefault();
               $.ajax({
                    method : "POST",
                    url : '{{ route('transfer.getimage') }}',
                    dataType : 'json',
                    data : {"data" : $(this).data("value")},
               }).done(function(rec){
                    $("#exampleModalLiveLabel").text(rec.order.order_no);
                    $("#transfer_slip_img").attr("src", '{{asset('uploads/transfers/')}}' + '/' + rec.image);
                    $("#exampleModalLive").modal('show');
               }).fail(function(){

               });
          });

     });
     </script>
@endsection
