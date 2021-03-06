@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
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
                                             <h5 class="m-b-10">{{$titie}}</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                             <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                                             <li class="breadcrumb-item"><a href="{{route('product')}}">สินค้าทั้งหมด</a></li>
                                             <li class="breadcrumb-item">{{$titie}}</li>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="row">
                         <div class="col-sm-12">
                              <div class="card">
                                   <div class="card-body">
                                        <h5><i class="fas fa-qrcode mr-2"></i>Scan Qr-Code</h5>
                                        <hr/>
                                        <div class="form-group mb-2 col-12">
                                             <input type="text" id="qr_code" class="form-control" placeholder="สแกน Qr-Code ที่นี่">
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-sm-12">
                              <div class="card">
                                   <form id="FormAdd">
                                        <div class="card-body">
                                             <h5>ข้อมูลสินค้า</h5>
                                             <hr/>
                                             <div class="row">
                                                  <div class="col-md-12 text-center">
                                                     <div class="form-group">
                                                          <img id="preview_img" src="{{asset('assets/images/product/prod-0.jpg')}}" alt="" style=" height: 100px; width: 100px;" />
                                                     </div>
                                                  </div>
                                                <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label class="form-label">SKU</label>
                                                         <input type="text" class="form-control" id="sku" disabled>
                                                         <input type="hidden" class="form-control" id="product_id" name="product_id">
                                                     </div>
                                                </div>
                                                <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label class="form-label">ชื่อสินค้า</label>
                                                         <input type="text" class="form-control" id="name" disabled>
                                                     </div>
                                                </div>
                                                <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label class="form-label">ประเภทสินค้า</label>
                                                         <input type="text" class="form-control" id="product_type" disabled>
                                                     </div>
                                                </div>
                                                <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label class="form-label">บริษัท</label>
                                                         <input type="text" class="form-control" id="company" disabled>
                                                     </div>
                                                </div>
                                                <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label class="form-label">จำนวน</label>
                                                         <input type="text" class="form-control number-only" id="qty" name="qty">
                                                     </div>
                                                </div>

                                             </div>
                                        </div>
                                        <div class="card-footer">
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i>ยืนยันรับสินค้าเข้าโกดัง</button>
                                                  </div>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                         </div>
                    </div>
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

          $(document).ready(function() {
               $("#qr_code").focus();

               $("#qr_code").keypress(function(e){
                    if(e.which == 13) {
                         $("#preview_img").attr("src", '{{asset('assets/images/product/prod-0.jpg')}}');
                         $("#sku").val('');
                         $("#name").val('');
                         $("#product_type").val('');
                         $("#company").val('');
                         $("#qty").val('');
                         $.ajax({
                              method : "POST",
                              data : {"data" : $(this).val()},
                              url : '{{ route('warehouse.getqrcode') }}',
                              dataType : 'json',
                              beforeSend: function() {
                                   $("#preloaders").css("display", "block");
                              },
                         }).done(function(rec){
                              if(rec){
                                   $("#preview_img").attr("src", '{{asset('uploads/products/')}}' + '/' + rec.image);
                                   $("#product_id").val(rec.id);
                                   $("#sku").val(rec.sku);
                                   $("#name").val(rec.name);
                                   $("#product_type").val(rec.product_type.name);
                                   $("#company").val(rec.company.name);
                              } else {
                                   notify("top", "right", "feather icon-layers", "danger", "", "", "ไม่พบ QR Code นี้ในระบบ");
                              }
                              $("#preloaders").css("display", "none");
                              $("#qr_code").val('');
                         }).fail(function(){
                              $("#preloaders").css("display", "none");
                              swal("system.system_alert","system.system_error","error");
                         });
                    }
               });

               $('#FormAdd').validate({
                    ignore: '.ignore, .select2-input',
                    focusInvalid: false,
                    rules: {
                         'qty' : {
                              required: true,
                              number: true
                         },
                    },
                    messages: {
                         'qty' : {
                              required: "กรุณาระบุจำนวน"
                         },
                    },
                    // Errors //
                    errorPlacement: function errorPlacement(error, element) {
                         var $parent = $(element).parents('.form-group');
                         // Do not duplicate errors
                         if ($parent.find('.jquery-validation-error').length) {
                              return;
                         }
                         $parent.append(
                              error.addClass('jquery-validation-error small form-text invalid-feedback')
                         );
                    },
                    highlight: function(element) {
                         var $el = $(element);
                         var $parent = $el.parents('.form-group');

                         $el.addClass('is-invalid');

                         // Select2 and Tagsinput
                         if ($el.hasClass('select2-hidden-accessible') || $el.attr('data-role') === 'tagsinput') {
                              $el.parent().addClass('is-invalid');
                         }
                    },
                    unhighlight: function(element) {
                         $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
                    },
                    submitHandler: function (form) {
                         var form = $('#FormAdd')[0];
                         var formData = new FormData(form);
                         $.ajax({
                              method : "POST",
                              url : '{{ route('warehouse.store') }}',
                              dataType : 'json',
                              data : formData,
                              processData: false,
                              contentType: false,
                         }).done(function(rec){
                              if (rec.status == 1) {
                                   swal("", rec.content, "success").then(function(){
                                        window.location.href = "{{ route('warehouse') }}";
                                   });
                              } else {
                                   notify("top", "right", "fas fa-exclamation-triangle", "danger", "", "", "บันทึกข้อมูลไม่สำเร็จ กรุณากรอกข้อมูลให้ครบถ้วน");
                              }
                         }).fail(function(){

                         });
                    },
                    invalidHandler: function (form) {

                    }
               });
          });
     </script>
@endsection
