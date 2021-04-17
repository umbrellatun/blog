@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
     <div class="pcoded-inner-content">
          <div class="main-body">
               <div class="page-wrapper">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                         <div class="page-block">
                              <div class="row align-items-center">
                                   <div class="col-md-12">
                                        <div class="page-header-title">
                                             <h5 class="m-b-10">{{$titie}} {{$order->order_no}}</h5>
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
                    <form id="FormAdd">
                         <div class="row">
                              <div class="col-sm-12">
                                   <div class="card">
                                        <div class="card-body">
                                             <h5>Scan Qr-Code</h5>
                                             <hr/>
                                             <div class="form-group mb-2 col-12">
                                                  <input type="text" id="qr_code" class="form-control" placeholder="สแกน Qr-Code ที่นี่">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-xl-6 col-md-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>สินค้า</h5>
                                        </div>
                                        <div class="card-body table-border-style">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <tr class="border-bottom-danger">
                                                                 <th>#</th>
                                                                 <th>ชื่อสินค้า</th>
                                                                 <th>ชิ้นที่</th>
                                                                 <th>สถานะ</th>
                                                                 <th>นำออก</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach ($order->OrderProduct as $order_product)
                                                                 @if ($i % 2 == 0)
                                                                      @php $class = 'border-bottom-primary'; @endphp
                                                                 @else
                                                                      @php $class = 'border-bottom-warning'; @endphp
                                                                 @endif
                                                                 <tr class="{{$class}}">
                                                                      <td>{{$i}}</td>
                                                                      <td>{{$order_product->Product->name}}</td>
                                                                      <td>{{$order_product->sort}} / {{$order_product->pieces}}</td>
                                                                      <td><span id="scaned_{{$order_product->id}}">{{ ($order_product->status == 'S' ? 'สแกนแล้ว' : 'รอสแกน') }}</span></td>
                                                                      <td>
                                                                           <div id="btn_area_{{$order_product->id}}" class="btn-group btn-group-sm">
                                                                           @if ($order_product->status == 'S')
                                                                                <button class="btn btn-danger btn-delete text-white" data-value="{{$order_product->id}}">
                                                                                     <i class="ace-icon feather icon-trash-2 bigger-120"></i>
                                                                                </button>
                                                                           @endif
                                                                           </div>
                                                                      </td>
                                                                 </tr>
                                                                 @php $i++; @endphp
                                                            @endforeach
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="col-xl-6 col-md-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>กล่อง</h5>
                                        </div>
                                        <div class="card-body table-border-style">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <tr class="border-bottom-danger">
                                                                 <th>#</th>
                                                                 <th>ชื่อสินค้า</th>
                                                                 <th>ชิ้นที่</th>
                                                                 <th>สถานะ</th>
                                                                 <th>นำออก</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach ($order->OrderBoxs as $order_box)
                                                                 @if ($i % 2 == 0)
                                                                      @php $class = 'border-bottom-primary'; @endphp
                                                                 @else
                                                                      @php $class = 'border-bottom-warning'; @endphp
                                                                 @endif
                                                                 <tr class="box_{{$class}}">
                                                                      <td>{{$i}}</td>
                                                                      <td>{{$order_box->Box->size}}<br/>{{$order_box->Box->description}}</td>
                                                                      <td>{{$order_box->sort}} / {{$order_box->pieces}}</td>
                                                                      <td><span id="boc_scaned_{{$order_box->id}}">{{ ($order_box->status == 'S' ? 'สแกนแล้ว' : 'รอสแกน') }}</span></td>
                                                                      <td>
                                                                           <div id="box_btn_area_{{$order_box->id}}" class="btn-group btn-group-sm">
                                                                           @if ($order_box->status == 'S')
                                                                                <button class="btn btn-danger btn-delete text-white" data-value="{{$order_box->id}}">
                                                                                     <i class="ace-icon feather icon-trash-2 bigger-120"></i>
                                                                                </button>
                                                                           @endif
                                                                           </div>
                                                                      </td>
                                                                 </tr>
                                                                 @php $i++; @endphp
                                                            @endforeach
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </form>
               </div>
          </div>
     </div>
@endsection
@section('js_bottom')
     <!-- jquery-validation Js -->
     <script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
     <!-- sweet alert Js -->
     <script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>
     <!-- notification Js -->
     <script src="{{asset('assets/js/plugins/bootstrap-notify.min.js')}}"></script>
     <script type="text/javascript">
         $(document).ready(function() {
              $("#qr_code").focus();

              $("#pcoded").pcodedmenu({
                   themelayout: 'horizontal',
                   MenuTrigger: 'hover',
                   SubMenuTrigger: 'hover',
              });
         });

         $(document).ready(function() {
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
              };
              // [ notification-button ]

              $("#qr_code").keypress(function(e){
                   e.preventDefault();
                   if(e.which == 13) {
                        $.ajax({
                             method : "POST",
                             data : {"data" : $(this).val()},
                             url : '{{ route('pack.getqrcode') }}',
                             dataType : 'json'
                        }).done(function(rec){
                             if (rec.status == 1){
                                  $("#scaned_" + rec.order_product_id).text(rec.content);
                                  let btn = '';
                                  btn += '<button class="btn btn-danger btn-delete text-white" data-value="{{$order_product->id}}">';
                                  btn += '<i class="ace-icon feather icon-trash-2 bigger-120"></i>';
                                  btn += '</button>';
                                  $("#btn_area_" + rec.order_product_id).html(btn);
                                  notify("top", "right", "feather icon-layers", "success", "", "", "สแกนสำเร็จ");
                             } else if (rec.status == 2) {

                             } else {
                                  notify("top", "right", "feather icon-layers", "danger", "", "", rec.content);
                             }
                             $("#qr_code").val("");
                        }).fail(function(){
                             swal("system.system_alert","system.system_error","error");
                        });
                   }
              });

              $('body').on('click', '.btn-delete', function () {
                  swal({
                       title: 'คุณต้องการนำออกใช่หรือไม่?',
                       icon: "warning",
                       buttons: true,
                       dangerMode: true,
                  })
                  .then((result) => {
                       if (result == true){
                            var order_product_id = $(this).data("value")
                            $.ajax({
                                 method : "delete",
                                 url : url_gb + '/admin/pack/' + order_product_id,
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
                                      $("#scaned_" + order_product_id).text(rec.content);
                                      $("#btn_area_" + order_product_id).empty();
                                      notify("top", "right", "feather icon-layers", "success", "", "", "นำออกสำเร็จ");
                                 } else {
                                      notify("top", "right", "feather icon-layers", "danger", "", "", rec.content);
                                 }
                            }).fail(function(){
                                 $("#preloaders").css("display", "none");
                                 swal("", rec.content, "error");
                            });
                       }
                  });
             });
         });




     </script>
@endsection
