@extends('layouts.layout')
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
               <div class="col-xl-7">
                    <div class="card">
                         <div class="card-header">
                              <h5><i class="fas fa-wallet mr-2"></i>Wallet</h5>
                         </div>
                         <div class="card-body">
                              <div class="row">
                                  @foreach ($currencies as $currency)
                                       <div class="col-xl-6 col-md-6">
                                            <div class="card analytic-card {{$currency->bgcolor}}">
                                                 <div class="card-body">
                                                      <div class="row align-items-center m-b-25">
                                                           <div class="col-auto">
                                                                <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 50px;">
                                                           </div>
                                                           <div class="col text-right">
                                                                <h3 class="m-b-5 text-white">{{  number_format($user_orders->where('currency_id', '=', $currency->id)->sum('amount'), 2) }}</h3>
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
                                                  <th>No.</th>
                                                  <th>Order No.</th>
                                                  <th>จำนวนเงิน</th>
                                                  <th>สกุลเงิน</th>
                                                  <th>หมายเหตุ</th>
                                                  <th>วันที่ได้รับเงิน</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @php
                                                  $i = 1;
                                             @endphp
                                             @foreach ($user_orders as $key => $user_order)
                                                  <tr>
                                                       <td>{{$i}}</td>
                                                       <td>{{$user_order->Order->order_no}}</td>
                                                       <td>{{ number_format($user_order->Order->receive_money, 2)}}</td>
                                                       <td>{{$user_order->Currency->name}}</td>
                                                       <td>{{ isset($user_order->Order->remark) ? $user_order->Order->remark : '-' }}</td>
                                                       <td>{{$user_order->Order->received_at}}</td>
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
               <div class="col-xl-5">
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
     <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel"></h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body text-center">
                         <img src="{{asset('assets/images/product/prod-0.jpg')}}" id="transfer_slip_img" style=" height: 400px; width: 300px;"></img>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn  btn-secondary" data-dismiss="modal">ปิด</button>
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

     $('body').on('change','.status',function(e){
         e.preventDefault();
         if ($(this).val() == 'Y'){
              swal({
                    title: 'ตรวจสอบยอดเงินแล้วใช่หรือไม่?',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
              })
              .then((result) => {
                    if (result == true){
                         var transfer_id = $(this).data("value");
                         var value = $(this).val();
                         $.ajax({
                              method : "POST",
                              url : '{{ route('transfer.approve') }}',
                              dataType : 'json',
                              data : {"transfer_id" : transfer_id, "value" : value},
                              beforeSend: function() {
                                   $("#preloaders").css("display", "block");
                              },
                         }).done(function(rec){
                              $("#preloaders").css("display", "none");
                              if(rec.status == 1){
                                   swal(rec.title, rec.content, "success");
                                   $("#transfer_user_id"+transfer_id).text(rec.user.name + " " + rec.user.lastname);
                                   $("#transfer_status"+transfer_id).empty();
                                   $("#transfer_status"+transfer_id).html('<span class="text-success">อนุมัติแล้ว</span>');

                              }
                         }).fail(function(){
                              $("#preloaders").css("display", "none");

                         });
                    } else {
                         if (result == null) {
                              var transfer_id = $(this).data("value");
                              var value = $(this).val();
                              if (value == 'W'){
                                   $("#status_" + transfer_id).val('Y');
                              }
                              if (value == 'Y'){
                                   $("#status_" + transfer_id).val('W');
                              }
                         }
                    }
              });
         }
     });
</script>
@endsection
