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
                                   <h5 class="m-b-10">Dashboard sale</h5>
                              </div>
                              <ul class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                   <li class="breadcrumb-item"><a href="#!">Dashboard sale</a></li>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
          <!-- [ breadcrumb ] end -->
          <!-- [ Main Content ] start -->
          <div class="row">
               <!-- product profit start -->
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-red">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Total Profit</h6>
                                        <h3 class="m-b-0 text-white">$1,783</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-money-bill-alt text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-blue">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Total Orders</h6>
                                        <h3 class="m-b-0 text-white">15,830</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-database text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-green">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Average Price</h6>
                                        <h3 class="m-b-0 text-white">$6,780</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-dollar-sign text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-yellow">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Product Sold</h6>
                                        <h3 class="m-b-0 text-white">6,784</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-tags text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- product profit end -->

               <div class="col-xl-7 col-md-12">
                    <div class="card table-card">
                         <div class="card-header">
                              <h5>รอตรวจสอบหลักฐานการชำระเงิน</h5>
                         </div>
                         <div class="pro-scroll" style="height:500px; position:relative; overflow-y: scroll;">
                              <div class="card-body p-0">
                                   <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                             <thead>
                                                  <tr>
                                                       <th>No.</th>
                                                       <th>Order No.</th>
                                                       {{-- <th>ชื่อไฟล์</th> --}}
                                                       <th>จำนวนเงิน</th>
                                                       <th>สกุลเงิน</th>
                                                       <th>วันที่โอน</th>
                                                       <th>เวลาโอน</th>
                                                       <th>หมายเหตุ</th>
                                                       <th>สถานะ</th>
                                                       <th>action</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  @php $cnt = 1; @endphp
                                                  @foreach ($transfers as $key => $transfer)
                                                       <tr>
                                                            <td>{{$cnt++}}</td>
                                                            <td>{{$transfer->Order->order_no}}</td>
                                                            {{-- <td>{{$transfer->image}}</td> --}}
                                                            <td>{{$transfer->amount}}</td>
                                                            <td>{{$transfer->Currency->name}}</td>
                                                            <td>{{$transfer->transfer_date}}</td>
                                                            <td>{{$transfer->transfer_hours}}:{{$transfer->transfer_minutes}}</td>
                                                            <td>{{ ($transfer->note) ? $transfer->note : '-' }}</td>
                                                            <td>
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
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/js/menu-setting.min.js') }}"></script>
<!-- sweet alert Js -->
<script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>
<script>
     $(document).ready(function() {
          $('[data-toggle="tooltip"]').tooltip();
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
