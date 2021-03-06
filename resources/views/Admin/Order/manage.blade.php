@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
@section('css_bottom')
@endsection
@section('body')
    <div class="pcoded-inner-content">
       <div class="main-body">
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
                                     <li class="breadcrumb-item">{{$titie}}</li>
                                </ul>
                           </div>
                      </div>
                 </div>
            </div>
            <div class="page-wrapper">
                 <div class="row">
                      <div class="col-xl-4 col-md-12">
                           <div class="card analytic-card bg-c-green">
                                <div class="card-body">
                                     <div class="row align-items-center m-b-25">
                                          <div class="col-auto">
                                               <i class="fas fa-shopping-cart text-c-green f-18 analytic-icon"></i>
                                          </div>
                                          <div class="col text-right">
                                               <h3 class="m-b-5 text-white">{{$order->order_no}}</h3>
                                               <h6 class="m-b-0 text-white"></h6>
                                          </div>
                                     </div>
                                     <p class="m-b-0  text-white d-inline-block">รวมทั้งสิ้น : </p>
                                     @php
                                     $sum_product_bath = 0;
                                     $sum_product_lak = 0;
                                     @endphp
                                     @foreach ($order->OrderProduct as $order_product)
                                          @php
                                          $sum_product_bath += $order_product->price_bath;
                                          $sum_product_lak += $order_product->price_lak;
                                          @endphp
                                     @endforeach
                                     <h5 class="text-white d-inline-block m-b-0">฿{{number_format($sum_product_bath, 2)}}</h5>
                                     <h6 class="m-b-0 text-white m-b-0  m-l-10 ml-5">&nbsp; &nbsp; &nbsp; LAK {{number_format($sum_product_lak, 2)}}</h6>
                                     <h6 class="m-b-0 d-inline-block  text-white float-right"><i class="fas fa-calendar-alt m-r-5"></i>{{ date_format($order->created_at, 'd-M-Y') }}</h6>
                                </div>
                           </div>
                      </div>

                      <div class="col-md-12 col-lg-4">
                           <div class="card bg-c-yellow">
                                <div class="card-body text-center">
                                     <i class="fas fa-braille text-c-blue d-block f-40"></i>
                                     <h4 class="m-t-20 text-white">สถานะ</h4>
                                     <p class="m-b-20"></p>
                                     <h5 class="text-white d-inline-block m-b-0">
                                          @if ($order->status == 'W')
                                               <span class="text-primary"><u>รอแนบหลักฐานการโอน</u></span>
                                          @elseif($order->status == 'WA')
                                               <span class="text-primary"><u>ตรวจสอบหลักฐานการโอนแล้ว รอแพ็ค</u></span>
                                          @elseif($order->status == 'P')
                                               <span class="text-primary"><u>แพ็คสินค้าแล้ว อยู่ระหว่างจัดส่ง</u></span>
                                          @elseif($order->status == 'T')
                                               <span class="text-primary"><u>จัดส่งแล้วรอปรับสถานะ</u></span>
                                          @elseif($order->status == 'S')
                                               <span class="text-success"><u>เสร็จสมบูรณ์</u></span>
                                          @endif
                                     </h5>
                                </div>
                           </div>
                      </div>
                      <div class="col-md-12 col-lg-4">
                           <a href="{{route('order.edit',['id' => $order->id])}}">
                                <div class="card bg-c-yellow">
                                     <div class="card-body text-center">
                                          <i class="fas fa-edit text-c-blue d-block f-40"></i>
                                          <h4 class="m-t-20 text-white"><span class="text-c-blue">แก้ไข</span>คำสั่งซื้อ</h4>
                                          <p class="m-b-20"></p>
                                          <button class="btn btn-primary btn-sm btn-round">คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div>
                      <div class="col-md-12 col-lg-4">
                           <a href="{{route('order.coverSheet',['id' => $order->id])}}" target="_blank">
                                <div class="card bg-primary">
                                     <div class="card-body text-center">
                                          <i class="fas fa-qrcode text-white d-block f-40"></i>
                                          <h4 class="m-t-20 text-white"><span class="text-c-yellow">พิมพ์</span>คิวอาร์โค้ด</h4>
                                          <p class="m-b-20">&nbsp;</p>
                                          <button class="btn btn-primary btn-sm btn-round">คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div>
                      {{-- <div class="col-md-12 col-lg-4">
                           <a href="{{route('transfer',['order_id' => $order->id])}}">
                                <div class="card bg-primary">
                                     <div class="card-body text-center">
                                          <i class="fas fa-money-check-alt text-c-white d-block f-40"></i>
                                          <h4 class="m-t-20 text-white"><span class="text-c-yellow">หลักฐาน</span>การโอน</h4>
                                          <p class="m-b-20"><u>รอตรวจสอบ {{ count($order->Transfer->where('status', '=', 'W')) }} / {{ count($order->Transfer)}} สลิป</u></p>
                                          <button class="btn btn-primary btn-sm btn-round">คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div> --}}
                      @if ($user->Role->id == 1)

                           @if ($order->status != 'W')

                           @endif
                      @endif
                      <div class="col-md-12 col-lg-4">
                           <a href="{{route('transfer',['order_id' => $order->id])}}">
                                <div class="card bg-primary">
                                     <div class="card-body text-center">
                                          <i class="fas fa-money-check-alt text-c-white d-block f-40"></i>
                                          <h4 class="m-t-20 text-white"><span class="text-c-yellow">ตรวจสอบ</span>หลักฐานการโอน</h4>
                                          <p class="m-b-20"><u>รอตรวจสอบ {{ count($order->Transfer->where('status', '=', 'W')) }} / {{ count($order->Transfer)}} สลิป</u></p>
                                          <button class="btn btn-primary btn-sm btn-round">Admin คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div>
                      <div class="col-md-12 col-lg-4">
                           <a href="{{route('pack.create',['order_id' => $order->id])}}">
                                <div class="card bg-primary">
                                     <div class="card-body text-center">
                                          <i class="fas fa-box-open text-c-white d-block f-40"></i>
                                          <h4 class="m-t-20 text-white"><span class="text-c-white">Admin </span></h4>
                                          <h4 class="m-t-20 text-white"><span class="text-c-yellow">แพ็ค</span>สินค้า</h4>
                                          <button class="btn btn-primary btn-sm btn-round">คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div>
                      @if ($order->status == 'P' or $order->status == 'T' or $order->status == 'S')

                      @endif
                      <div class="col-md-12 col-lg-4">
                           <a href="{{route('track',['order_id' => $order->id])}}">
                                <div class="card bg-primary">
                                     <div class="card-body text-center">
                                          <i class="fas fa-truck text-c-white d-block f-40"></i>
                                          <h4 class="m-t-20 text-white"><span class="text-c-yellow">Tracking</span>สินค้า</h4>
                                          <p class=""><u>{{$order->tracking_number}}</u><br/>{{$order->Shipping->name}}</p>
                                          <button class="btn btn-primary btn-sm btn-round">Admin คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div>
                      <div class="col-md-12 col-lg-4">
                           <a href="{{route('invoice',['order_id' => $order->id])}}">
                                <div class="card bg-primary">
                                     <div class="card-body text-center">
                                          <i class="fas fa-file-invoice text-c-white d-block f-40"></i>
                                          <h4 class="m-t-20 text-white"><span class="text-c-yellow">In</span>voice</h4>
                                          <p class="m-b-20">&nbsp;</p>
                                          <button class="btn btn-primary btn-sm btn-round">คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div>
                      @if ($order->status == 'T' || $order->status == 'S' || $order->status == 'C')

                      @endif
                      <div class="col-md-12 col-lg-4">
                           <div class="card bg-primary">
                                <div class="card-body text-center">
                                     <i class="fas fa-cogs text-c-white d-block f-40"></i>
                                     <h4 class="m-t-20 text-white"><span class="text-c-yellow">ปรับ</span>สถานะ</h4>
                                     <p class="m-b-20 form-group">
                                          <select class="form-control" id="adjust_status">
                                               <option value>Please select</option>
                                               <option value="S" {{ $order->status == 'S' ? 'selected' : '' }}>จัดส่งสำเร็จ</option>
                                               <option value="C" {{ $order->status == 'C' ? 'selected' : '' }}>ยกเลิก Order</option>
                                          </select>
                                     </p>
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

     <!-- jquery-validation Js -->
     <script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
     <!-- sweet alert Js -->
     <script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>

     <script type="text/javascript">
         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
            });
         });

         $('body').on('click', '.btn-delete', function () {
              swal({
                   title: 'คุณต้องการลบใช่หรือไม่?',
                   icon: "warning",
                   buttons: true,
                   dangerMode: true,
              })
              .then((result) => {
                   if (result == true){
                        $.ajax({
                             method : "delete",
                             url : url_gb + '/admin/order/' + $(this).data("value"),
                             dataType : 'json',
                             headers: {
                                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                             },
                             beforeSend: function() {
                                  $("#preloaders").css("display", "block");
                             },
                        }).done(function(rec){
                             $("#preloaders").css("display", "none");
                             if(rec.status==1){
                                  swal("", rec.content, "success").then(function(){
                                       window.location.href = "{{ route('user') }}";
                                  });
                             } else {
                                  swal("", rec.content, "warning");
                             }
                        }).fail(function(){
                             $("#preloaders").css("display", "none");
                             swal("", rec.content, "error");
                        });
                   }
              });
         });

         $('body').on('change', '#adjust_status', function (e) {
              e.preventDefault();
              swal({
                   title: 'คุณต้องการเปลี่ยนสถานะใช่หรือไม่?',
                   icon: "warning",
                   buttons: true,
                   dangerMode: true,
              })
              .then((result) => {
                   if (result == true){
                        var status = $(this).val();
                        var order_id = '{{$order->id}}';
                        $.ajax({
                             method : "POST",
                             url : '{{ route('order.adjustStatus') }}',
                             dataType : 'json',
                             data : {"status" : status, "order_id" : order_id},
                             beforeSend: function() {
                                  $("#preloaders").css("display", "block");
                             },
                        }).done(function(rec){
                             $("#preloaders").css("display", "none");
                             if(rec.status == 1){
                                  // $("#status_" + transfer_id).prop("disabled", true);
                             }
                        }).fail(function(){
                             $("#preloaders").css("display", "none");

                        });
                   }
              });
         });



     </script>
@endsection
