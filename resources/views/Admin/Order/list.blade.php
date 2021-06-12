@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
@section('css_bottom')
@endsection
@section('body')
    <div class="pcoded-inner-content">
       <div class="main-body">
           <div class="page-wrapper">
               <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="d-inline-block mb-0">{{$titie}}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="btn-cust">
                                         <a href="{{ route('order.create') }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus mr-2"></i>สร้างคำสั่งซื้อ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-none">
                            <div class="card-body shadow border-0">
                                 <div class="row mt-1 mb-3">
                                      <a href="#" class="print-invoice-btn btn waves-effect waves-light btn-success m-0"><i class="fas fa-print mr-2"></i>พิมพ์ใบแจ้งหนี้</a>
                                      {{-- <button type="button" class="btn btn-success print-invoice-btn">พิมพ์ใบแจ้งหนี้</button> --}}
                                 </div>
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                           <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">Order no.</th>
                                                <th class="border-top-0">วันที่สร้าง</th>
                                                <th class="border-top-0">ลูกค้า</th>
                                                <th class="border-top-0">จำนวนเงิน(บาท)</th>
                                                <th class="border-top-0">จำนวนเงิน(กีบ)</th>
                                                <th class="border-top-0">วิธีการจัดส่ง</th>
                                                <th class="border-top-0">สถานะ</th>
                                                <th class="border-top-0">action</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($orders as $order)
                                                  @php
                                                       $sum_product_bath = 0;
                                                       $sum_product_lak = 0;
                                                       $sum_box_bath = 0;
                                                       $sum_box_lak = 0;
                                                  @endphp
                                                  @foreach ($order->OrderProduct as $order_product)
                                                       @php
                                                            $sum_product_bath += $order_product->price_bath;
                                                            $sum_product_lak += $order_product->price_lak;
                                                       @endphp
                                                  @endforeach
                                                  @foreach ($order->OrderBoxs as $order_box)
                                                       @php
                                                            $sum_box_bath += $order_box->price_bath;
                                                            $sum_box_lak += $order_box->price_lak;
                                                       @endphp
                                                  @endforeach
                                                  <tr>
                                                       <td>
                                                            <div class="form-group">
                                                                 <div class="form-check">
                                                                      <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                 </div>
                                                            </div>
                                                       </td>
                                                       <td>{{$order->order_no}}</td>
                                                       <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                       <td>{{$order->Customer->name}}</td>
                                                       <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                       <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                       <td>{{ $order->Shipping->name }}</td>
                                                       <td>
                                                            @if ($order->status == 'W')
                                                                 @php
                                                                 $txt_status = 'รอแนบหลักฐานการโอน';
                                                                 $class = 'text-warning';
                                                                 @endphp
                                                            @elseif ($order->status == 'WA')
                                                                 @php
                                                                 $txt_status = 'ตรวจสอบหลักฐานการโอนแล้ว รอแพ็ค';
                                                                 $class = 'text-warning';
                                                                 @endphp
                                                            @elseif ($order->status == 'P')
                                                                 @php
                                                                 $txt_status = 'แพ็คสินค้าแล้ว อยู่ระหว่างจัดส่ง';
                                                                 $class = 'text-primary';
                                                                 @endphp
                                                            @elseif ($order->status == 'T')
                                                                 @php
                                                                 $txt_status = 'จัดส่งแล้ว รอปรับสถานะ';
                                                                 $class = 'text-primary';
                                                                 @endphp
                                                            @elseif ($order->status == 'S')
                                                                 @php
                                                                 $txt_status = 'เสร็จสมบูรณ์';
                                                                 $class = 'text-success';
                                                                 @endphp
                                                            @endif
                                                            <span class="{{$class}}"> {{$txt_status}} </span>
                                                       </td>
                                                       <td>
                                                            <div class="btn-group btn-group-sm">
                                                                 {{-- <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                      <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                 </a> --}}
                                                                 <a class="btn btn-primary btn-edit text-white" href="{{ route('order.manage', ['id' => $order->id]) }}">
                                                                      <i class="fas fa-bars"></i>
                                                                 </a>
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
     <!-- notification Js -->
     <script src="{{asset('assets/js/plugins/bootstrap-notify.min.js')}}"></script>
     <script type="text/javascript">
         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
            });

            function notify(from, align, icon, type, animIn, animOut, title) {
                 $.notify({
                      icon: icon,
                      title:  title,
                      message: '',
                      url: ''
                 }, {
                      element: 'body',
                      type: type,
                      allow_dismiss: true,
                      placement: {
                           from: from,
                           align: align
                      },
                      offset: {
                           x: 30,
                           y: 30
                      },
                      spacing: 10,
                      z_index: 999999,
                      delay: 2500,
                      timer: 1000,
                      url_target: '_blank',
                      mouse_over: false,
                      animate: {
                           enter: animIn,
                           exit: animOut
                      },
                      icon_type: 'class',
                      template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                      '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                      '<span data-notify="icon"></span> ' +
                      '<span data-notify="title">{1}</span> ' +
                      '<span data-notify="message">{2}</span>' +
                      '<div class="progress" data-notify="progressbar">' +
                      '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                      '</div>' +
                      '<a href="{3}" target="{4}" data-notify="url"></a>' +
                      '</div>'
                 });
            }

            $('body').on('click', '.print-invoice-btn', function (e) {
                 var order_arr = [];
                 $(".order_chk").each(function(i, obj) {
                      if ($(this).prop("checked") == true){
                           order_arr.push($(this).val());
                      }
                 });
                 if (order_arr.length == 0){
                      notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
                 }
            });

            $('body').on('change', '.order_chk', function (e) {
                 e.preventDefault();
                 var order_arr = [];
                 $(".order_chk").each(function(i, obj) {
                      if ($(this).prop("checked") == true){
                           order_arr.push($(this).val());
                      }
                 });
                 $(".print-invoice-btn").attr("href", url_gb + '/admin/dashboard/printInvoice/' + order_arr);

                 // $(".order_chk").each(function(i, obj) {
                 //      if ($(this).prop("checked") == true){
                 //
                 //      }
                      // $.ajax({
                      //      method : "POST",
                      //      url : '',
                      //      dataType : 'json',
                      //      data : {
                      //           "data" : order_arr
                      //      },
                      //      beforeSend: function() {
                      //           $("#preloaders").css("display", "block");
                      //      },
                      // }).done(function(rec){
                      //      $("#preloaders").css("display", "none");
                      //
                      // }).fail(function(){
                      //      $("#preloaders").css("display", "none");
                      //
                      // });
                      // else {
                      //      notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
                      // }
                 // });
            });
       });

       $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
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
