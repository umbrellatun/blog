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
                                <div class="card bg-white">
                                     <div class="card-header">
                                          <h5>หลักฐานการโอนเงินจาก Admin</h5>
                                     </div>
                                     <div class="card-body">
                                          <div class="dt-responsive table-responsive">
                                               <table class="table nowrap">
                                                    <thead>
                                                        <tr>
                                                             <th class="text-left">#</th>
                                                             <th class="text-left">รหัสการโอน</th>
                                                             <th class="text-center">โอนเล้ว(THB)</th>
                                                             <th class="text-center">โอนเล้ว(LAK)</th>
                                                             <th class="text-center">วันที่สร้างรายการ</th>
                                                        </tr>
                                                   </thead>
                                                   <tbody>
                                                        @php
                                                             $i = 1;
                                                        @endphp
                                                        @foreach ($user_order_transfers as $key => $user_order_transfer)
                                                             <tr>
                                                                  <td>{{$i}}</td>
                                                                  <td><a href="#" class="transfer_code text-primary" data-value="{{$user_order_transfer->id}}">#{{ str_pad($user_order_transfer->id, 5, '0', STR_PAD_LEFT) }}</a></td>
                                                                  <td class="text-right">{{ number_format($user_order_transfer->amount_thb) }}</td>
                                                                  <td class="text-right">{{ number_format($user_order_transfer->amount_lak) }}</td>
                                                                  <td class="text-center">{{$user_order_transfer->created_at}}</td>
                                                             </tr>
                                                             @php
                                                                  $i++;
                                                             @endphp
                                                        @endforeach
                                                   </tbody>
                                               </table>
                                          </div>
                                     </div>
                                </div>
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
                                                                                 <th class="text-left"><input type="checkbox" class="order_chk_all order_chk_all_{{$company->id}}" data-value="{{$company->id}}"></th>
                                                                                 <th class="text-left">Order NO.</th>
                                                                                 <th class="text-left">วันที่สร้าง Order</th>
                                                                                 <th class="text-center">โอนเล้ว(THB)</th>
                                                                                 <th class="text-center">โอนเล้ว(LAK)</th>
                                                                                 <th class="text-center">เก็บเงินปลายทาง (THB)</th>
                                                                                 <th class="text-center">เก็บเงินปลายทาง (LAK)</th>
                                                                                 <th class="text-center">วันเวลาที่โอนเงิน</th>
                                                                                 <th class="text-center">โอนเงินโดย</th>
                                                                                 <th class="text-center">หมายเหตุ</th>
                                                                                 <th class="text-center">รหัสการโอน</th>
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
                                                                                           <td class="text-center">
                                                                                                <div class="form-group">
                                                                                                     <div class="form-check">
                                                                                                          <input type="checkbox" class="order_chk order_chk_{{$company->id}} form-check-input" data-value="{{$company->id}}" value="{{$order->id}}">
                                                                                                     </div>
                                                                                                </div>
                                                                                           </td>
                                                                                           <td class="text-left">{{$order->order_no}}</td>
                                                                                           <td class="text-left">{{$order->created_at}}</td>
                                                                                           <td class="text-right">{{ number_format($amount_thb) }}</td>
                                                                                           <td class="text-right">{{ number_format($amount_lak) }}</td>
                                                                                           <td class="text-right">{{ number_format($order->UserOrder->receive_money_thb) }}</td>
                                                                                           <td class="text-right">{{ number_format($order->UserOrder->receive_money_lak) }}</td>
                                                                                           <td class="text-center">{{$order->UserOrder->transfer_date}}</td>
                                                                                           <td class="text-center">{{$order->UserOrder->transfer_by}}</td>
                                                                                           <td class="text-center">{{ isset($order->UserOrder->remark) ? $order->UserOrder->remark : '-' }}</td>
                                                                                           <td class="text-center"><a href="#" class="transfer_code text-primary" data-value="{{$order->UserOrder->user_order_transfer_id}}">#{{ str_pad($order->UserOrder->user_order_transfer_id, 5, '0', STR_PAD_LEFT) }}</a></td>
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
                 </div>
             </div>
         </div>
     </div>
@endsection
@section('modal')
     <div class="modal fade view-transfer-slip-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel">หลักฐานการโอน</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <div class="table-responsive">
                              <table class="table" id="transfer_table">
                                   <thead>
                                        <tr>
                                             <th>#</th>
                                             <th>รหัสการโอน</th>
                                             <th>ชื่อไฟล์</th>
                                             <th>จำนวนเงิน(THB)</th>
                                             <th>จำนวนเงิน(LAK)</th>
                                             <th>วันที่โอน</th>
                                             <th>เวลาโอน</th>
                                             <th>หมายเหตุ</th>
                                             <th>ผู้โอน</th>
                                             <th>action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                              </table>
                         </div>
                    </div>
                    <div class="modal-footer">
                         {{-- <button type="button" class="btn btn-primary btn-check-transfer"><i class="fa fa-check mr-2" aria-hidden="true"></i>ตรวจสอบแล้ว</button> --}}
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                    </div>
               </div>
          </div>
     </div>

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
     function inArray(needle, haystack) {
          var length = haystack.length;
          for(var i = 0; i < length; i++) {
               if(typeof haystack[i] == 'object') {
                    if(arrayCompare(haystack[i], needle)) return true;
               } else {
                    if(haystack[i] == needle) return true;
               }
          }
          return false;
     }

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


          $('body').on('click', '.transfer_code', function (e) {
               e.preventDefault();
               var user_order_transfer_id = $(this).data("value");
               $.ajax({
                    method : "post",
                    url : '{{ route('finance.getTranfersView') }}',
                    data : { "user_order_transfer_id" : user_order_transfer_id },
                    dataType : 'json',
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                         $("#transfer_table tbody").empty();
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    var html = '';
                    var i = 1;
                    var currency_name = '';
                    if(rec){
                         $.each(rec, function( index, detail ) {
                              html += '<tr>';
                              html += '<td>'+i+'</td>';
                              html += '<td><span class="text-primary">#'+ (detail.user_order_transfer_id).toString().padStart(5,'0') +'</span></td>';
                              html += '<td>'+detail.image+'</td>';
                              if (detail.currency_id == 1) {
                                   html += '<td class="text-right">'+ addNumformat(detail.amount)+'</td>';
                                   html += '<td class="text-right"></td>';
                              } else {
                                   html += '<td class="text-right"></td>';
                                   html += '<td class="text-right">'+ addNumformat(detail.amount)+'</td>';
                              }
                              html += '<td>'+detail.transfer_date+'</td>';
                              html += '<td>' + (detail.transfer_hours).toString().padStart(2,'0') + ":" + (detail.transfer_minutes).toString().padStart(2,'0') + '</td>';
                              if (detail.remark){
                                   html += '<td>'+ detail.remark +'</td>';
                              } else {
                                   html += '<td>-</td>';
                              }
                              html += '<td>'+detail.user.name + ' ' + detail.user.lastname+'</td>';
                              html += '<td>';
                              html += '<a href="#" class="btn btn-success btn-view" data-toggle="modal" data-value="'+detail.id+'" title="ดูหลักฐานการโอน">';
                              html += '<i class="fa fa-eye"></i>';
                              html += '</a>';
                              html += '</td>';
                              html += '</tr>';

                              i = i+1;
                         });
                         $("#transfer_table tbody").append(html);
                         $(".view-transfer-slip-modal").modal("show");
                    } else {

                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    // swal("", rec.content, "error");
               });
          });

          $('body').on('click','.btn-view',function(e){
               e.preventDefault();
               $.ajax({
                    method : "POST",
                    url : '{{ route('finance.getimage') }}',
                    dataType : 'json',
                    data : {"data" : $(this).data("value")},
               }).done(function(rec){
                    $("#transfer_slip_img").attr("src", '{{asset('')}}' + '/' + rec.image);
                    $("#exampleModalLive").modal('show');
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });
          });

          $('body').on('change', '.order_chk_all', function (e) {
               e.preventDefault();
               var data_value = $(this).data("value");
               if ($(this).prop("checked") == true) {
                    $(".order_chk_" + data_value).prop("checked", true);
               } else {
                    $(".order_chk_" + data_value).prop("checked", false);
               }
          });

          $('body').on('change', '.order_chk', function (e) {
               e.preventDefault();
               var data_value = $(this).data("value");
               order_arr = [];
               $(".order_chk_" + data_value).each(function(i, obj) {
                    order_arr.push($(this).prop("checked"));
               });
               if(inArray(false, order_arr)){
                    $(".order_chk_all_" + data_value).prop("checked", false);
               } else {
                    $(".order_chk_all_" + data_value).prop("checked", true);
               }
          });
     });
     </script>
@endsection
