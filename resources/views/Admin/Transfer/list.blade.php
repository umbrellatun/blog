@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
@section('css_bottom')
@endsection
@section('body')
    <div class="pcoded-inner-content">
       <div class="main-body">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                 <div class="page-block">
                      <div class="row align-items-center">
                           <div class="col-md-12">
                                <div class="page-header-title">
                                     <h5 class="m-b-10">{{$titie}}</h5>
                                </div>
                                <ul class="breadcrumb">
                                     <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                                     <li class="breadcrumb-item"><a href="{{route('order')}}">รายการสั่งซื้อ</a></li>
                                     <li class="breadcrumb-item"><a href="{{route('order.manage', ['id' => $order->id])}}">จัดการคำสั่งซื้อ</a></li>
                                     <li class="breadcrumb-item">{{$titie}}</li>
                                </ul>
                           </div>
                      </div>
                 </div>
            </div>
            <!-- [ breadcrumb ] end -->
           <div class="page-wrapper">
               <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="d-inline-block mb-0">{{$titie}} {{$order->order_no}}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="btn-cust">
                                         <a href="{{ route('transfer.create', ['order_id' => $order->id]) }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus"></i> แนบหลักฐานการโอน</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-none">
                            <div class="card-body shadow border-0">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
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
                                             @foreach ($transfers as $key => $transfer)
                                                  <tr>
                                                       <td>{{$i}}</td>
                                                       <td>{{$transfer->image}}</td>
                                                       <td>{{ number_format($transfer->amount, 2) }}</td>
                                                       <td>{{$transfer->transfer_date}}</td>
                                                       <td>{{$transfer->transfer_hours}}:{{$transfer->transfer_minutes}}</td>
                                                       <td>{{( strlen($transfer->remark) > 0 ? $transfer->remark : '-')}}</td>
                                                       <td id="transfer_status{{$transfer->id}}">
                                                            {{-- @if ($user->Role->id == 1)
                                                                 <select class="form-control status" size="1" id="status_{{$transfer->id}}" data-value="{{$transfer->id}}">
                                                                      <option value="W" {{ ($transfer->status == 'W') ? 'selected' : '' }}>รอตรวจสอบ</option>
                                                                      <option value="Y" {{ ($transfer->status == 'Y') ? 'selected' : '' }}>อนุมัติแล้ว</option>
                                                                 </select>
                                                            @else
                                                                 <span class="{{ ($transfer->status == 'W') ? 'text-danger' : 'text-success' }}">
                                                                      {{ ($transfer->status == 'W') ? 'รออนุมัติ' : 'อนุมัติแล้ว' }}
                                                                 </span>
                                                            @endif --}}
                                                            @if ($transfer->status == 'W')
                                                                 @if ($user->Role->id == 1)
                                                                      <select class="form-control status" size="1" id="status_{{$transfer->id}}" data-value="{{$transfer->id}}">
                                                                           <option value="W" {{ ($transfer->status == 'W') ? 'selected' : '' }}>รอตรวจสอบ</option>
                                                                           <option value="Y" {{ ($transfer->status == 'Y') ? 'selected' : '' }}>อนุมัติแล้ว</option>
                                                                      </select>
                                                                 @else
                                                                      <span class="badge badge-light-warning">รออนุมัติ</span>
                                                                 @endif
                                                            @else
                                                                 <span class="badge badge-light-success">อนุมัติแล้ว</span>
                                                            @endif
                                                       </td>
                                                       <td><span id="transfer_user_id{{$transfer->id}}">{{ isset($transfer->User) ? $transfer->User->name : '-' }} {{ isset($transfer->User) ? $transfer->User->lastname : '' }}</span></td>
                                                       <td>
                                                            <div class="btn-group btn-group-sm">
                                                                 {{-- @if ($transfer->status == 'W') --}}
                                                                      <a href="{{ route('transfer.edit', ['transfer_id' => $transfer->id]) }}" data-toggle="tooltip" title="แก้ไข" class="btn btn-warning btn-edit text-white">
                                                                           <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                      </a>
                                                                 {{-- @endif --}}
                                                                 <button type="button" class="btn btn-success btn-view" data-toggle="modal" title="" data-value="{{$transfer->id}}">
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
                                    </table>
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

     <!-- jquery-validation Js -->
     <script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
     <!-- sweet alert Js -->
     <script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>

     <script type="text/javascript">
         $(document).ready(function() {
              $('[data-toggle="tooltip"]').tooltip();
              $("#pcoded").pcodedmenu({
                   themelayout: 'horizontal',
                   MenuTrigger: 'hover',
                   SubMenuTrigger: 'hover',
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
