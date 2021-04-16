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
                                     <li class="breadcrumb-item">{{$titie}}</li>
                                </ul>
                           </div>
                      </div>
                 </div>
            </div>
            <!-- [ breadcrumb ] end -->
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
                           <a href="{{route('order.edit',['id' => $order->id])}}">
                                <div class="card">
                                     <div class="card-body text-center">
                                          <i class="fas fa-edit text-c-blue d-block f-40"></i>
                                          <h4 class="m-t-20"><span class="text-c-blue">แก้ไข</span>คำสั่งซื้อ</h4>
                                          <p class="m-b-20"></p>
                                          <button class="btn btn-primary btn-sm btn-round">คลิก</button>
                                     </div>
                                </div>
                           </a>
                      </div>
                      <div class="col-md-12 col-lg-4">
                           <a href="{{route('order.qrcode',['id' => $order->id])}}">
                                <div class="card">
                                     <div class="card-body text-center">
                                          <i class="fas fa-qrcode text-c-blue d-block f-40"></i>
                                          <h4 class="m-t-20"><span class="text-c-blue">พิมพ์</span>คิวอาร์โค้ด</h4>
                                          <p class="m-b-20"></p>
                                          <button class="btn btn-primary btn-sm btn-round">คลิก</button>
                                     </div>
                                </div>
                           </a>
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
     </script>
@endsection
