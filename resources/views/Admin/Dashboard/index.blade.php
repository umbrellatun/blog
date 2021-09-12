@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<!-- data tables css -->
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
@section('css_bottom')
@endsection
@section('body')
     <div class="pcoded-content">
          <!-- [ breadcrumb ] start -->
          <div class="page-header">
               <div class="page-block">
                    <div class="row align-items-center">
                         <div class="col-md-12">
                              <div class="page-header-title">
                                   <h5 class="m-b-10">Dashboard</h5>
                              </div>
                              <ul class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                   <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
          <!-- [ breadcrumb ] end -->
          <!-- [ Main Content ] start -->
          <div class="row">
               <div class="col-xl-9">
                    <div class="card">
                         <div class="card-header">
                              <h5><i class="fas fa-wallet mr-2"></i>Wallet</h5>
                         </div>
                         <div class="card-body">
                              <div class="row">
                                  @foreach ($currencies as $key => $currency)
                                       <div class="col-xl-6 col-md-6">
                                            <div class="card analytic-card {{$currency->bgcolor}}">
                                                 <div class="card-body">
                                                      <div class="row align-items-center m-b-25">
                                                           <div class="col-auto">
                                                                <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 50px;">
                                                           </div>
                                                           <div class="col text-right">
                                                                @if ($key == 0)
                                                                     <h3 class="m-b-5 text-white">{{  number_format($user_orders->sum('receive_money_thb'), 2) }}</h3>
                                                                @else
                                                                     <h3 class="m-b-5 text-white">{{  number_format($user_orders->sum('receive_money_lak'), 2) }}</h3>
                                                                @endif
                                                                <h6 class="m-b-0 text-white">{{$currency->name}}</h6>
                                                           </div>
                                                      </div>
                                                      <h5 class="text-white d-inline-block m-b-0 m-l-10">{{$currency->name_th}}</h5>
                                                 </div>
                                            </div>
                                       </div>
                                  @endforeach
                             </div>
                              <div class="table-responsive">
                                   <table class="table table-hover m-b-0">
                                        <thead>
                                             <tr>
                                                  <th class="text-center">No.</th>
                                                  <th class="text-left">Order No.</th>
                                                  <th class="text-center">จำนวนเงิน(THB)</th>
                                                  <th class="text-center">จำนวนเงิน(LAK)</th>
                                                  <th class="text-center">หมายเหตุ</th>
                                                  <th class="text-center">วันที่ได้รับเงิน</th>
                                                  <th class="text-center">action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @php
                                                  $i = 1;
                                             @endphp
                                             @foreach ($user_orders as $key => $user_order)
                                                  <tr>
                                                       <td class="text-center">{{$i}}</td>
                                                       <td class="text-left">{{$user_order->Order->order_no}}</td>
                                                       <td class="text-center">{{$user_order->receive_money_thb}}</td>
                                                       <td class="text-center">{{$user_order->receive_money_lak}}</td>
                                                       {{-- <td class="text-center">{{ number_format($user_order->Order->receive_money, 2)}}</td> --}}
                                                       {{-- <td class="text-center">{{$user_order->Currency->name}}</td> --}}
                                                       <td class="text-center">{{ isset($user_order->Order->remark) ? $user_order->Order->remark : '-' }}</td>
                                                       <td class="text-center">{{ $user_order->Order->received_at }}</td>
                                                       <td class="text-left">
                                                            <div class="overlay-edit" style="opacity: 1; background: none;">
                                                                 <a href="#" class="btn waves-effect waves-light btn-primary" data-id="{{$user_order->order_id}}" data-toggle="tooltip" title="โอนเงินให้ CEO">
                                                                      ทำการโอนเงิน
                                                                 </a>
                                                                 <a class="btn btn-warning text-white" data-toggle="tooltip" title="ใบแพ็คสินค้า" href="{{ route('order.coverSheet', ['id' => $user_order->order_id]) }}" target="_blank">
                                                                     <i class="fas fa-print"></i>
                                                                </a>
                                                                 @if (sizeof($user_order->Order->Transfer) > 0)
                                                                      <a href="#" class="btn waves-effect waves-light btn-info view-transfer-slip-btn" data-id="{{$user_order->order_id}}" data-toggle="tooltip" title="ดูหลักฐานการโอนทั้งหมด">
                                                                           <i class="fa fa-eye"></i>
                                                                      </a>
                                                                 @endif

                                                            </div>
                                                       </td>
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
               <div class="col-xl-3">
                    <div class="card">
                         <div class="card-header">
                              <h5>การจัดส่ง</h5>
                         </div>
                         <div class="card-body">
                              @foreach ($shippings as $key => $shipping)
                                   <div class="row m-b-25 align-items-center">
                                        <div class="col-auto p-r-0">
                                             <i class="fa fa-truck badge-light-primary feed-icon"></i>
                                        </div>
                                        <div class="col">
                                             <a href="{{ route('shipping', ['id' => $shipping->id]) }}">
                                                  <h6 class="m-b-5">{{$shipping->name}} <span class="text-muted float-right f-14">{{ count($shipping->ShippingOrder->where('status', 'S')) }}</span></h6>
                                             </a>
                                        </div>
                                   </div>
                              @endforeach
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
                                             <th>ชื่อไฟล์</th>
                                             <th>จำนวนเงิน</th>
                                             <th>วันที่โอน</th>
                                             <th>เวลาโอน</th>
                                             <th>หมายเหตุ</th>
                                             <th>สถานะ</th>
                                             <th>ผู้รับเงิน</th>
                                             <th>action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                              </table>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-primary btn-check-transfer"><i class="fa fa-check mr-2" aria-hidden="true"></i>ตรวจสอบแล้ว</button>
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


<script>
     //
     $(document).ready(function() {
       $("#pcoded").pcodedmenu({
            themelayout: 'horizontal',
            MenuTrigger: 'hover',
            SubMenuTrigger: 'hover',
       });
     });

     $.ajaxSetup({
         headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });

     $('body').on('click', '.view-transfer-slip-btn', function (e) {
          e.preventDefault();
          var order_id = $(this).data("id");
          $.ajax({
               method : "post",
               url : '{{ route('order.getTranfersView') }}',
               data : { "order_id" : order_id },
               dataType : 'json',
               headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },
               beforeSend: function() {
                    $("#preloaders").css("display", "block");
                    $("#transfer_table tbody").empty();
                    $(".btn-check-transfer").attr('data-value', "");
               },
          }).done(function(rec){
               $("#preloaders").css("display", "none");
               var html = '';
               var currency_name = '';
               if(rec.status==1){
                    $.each(rec.transfers, function( index, transfer ) {
                         html += '<tr>';
                         html += '<td>';
                         if (transfer.status == 'Y') {
                              html += '-';
                         } else {
                              html += '<input type="checkbox" class="transfer_chk" value="'+transfer.id+'">';
                         }
                         html += '</td>';
                         html += '<td>'+transfer.image+'</td>';
                         if (transfer.currency) {
                              currency_name = transfer.currency.name;
                         } else {
                              currency_name = '<span class="text-danger">ยังไม่ระบุสกุลเงิน</span>';
                         }
                         html += '<td>' + transfer.amount + ' ' + currency_name + '</td>';
                         html += '<td>'+transfer.transfer_date+'</td>';
                         if (transfer.transfer_hours && transfer.transfer_minutes){
                              html += '<td>'+ (transfer.transfer_hours.padStart(2, '0'))  + ":" + (transfer.transfer_minutes.padStart(2, '0')) +'</td>';
                         } else {
                              html += '<td>ไม่พบวันเวลาโอน</td>';
                         }
                         html += '<td>'+ ((transfer.remark) ? transfer.remark : '-') +'</td>';
                         html += '<td><span class="badge '+((transfer.status == 'Y') ? 'badge-light-success' : 'badge-light-warning')+'">'+ ((transfer.status == 'Y') ? 'ตรวจสอบแล้ว' : 'รอตรวจสอบ') +'</span></td>';
                         if (transfer.user){
                              html += '<td>'+transfer.user.name+' '+transfer.user.lastname+'</td>';
                         } else {
                              html += '<td>-</td>';
                         }
                         html += '<td>';
                         html += '<a href="#" class="btn btn-success btn-view" data-toggle="modal" data-value="'+transfer.id+'" title="ดูหลักฐานการโอน">';
                         html += '<i class="fa fa-eye"></i>';
                         html += '</a>';
                         html += '</td>';
                         html += '</tr>';
                    });
                    $("#transfer_table tbody").append(html);
                    $(".view-transfer-slip-modal").modal("show");
                    $(".btn-check-transfer").attr('data-value', order_id);
               } else {

               }
          }).fail(function(){
               $("#preloaders").css("display", "none");
               swal("", rec.content, "error");
          });
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


</script>
@endsection
