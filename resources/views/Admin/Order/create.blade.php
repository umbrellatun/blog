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
                                       <li class="breadcrumb-item"><a href="{{route('order')}}">รายการสั่งซื้อ</a></li>
                                       <li class="breadcrumb-item">{{$titie}}</li>
                                   </ul>
                              </div>
                           </div>
                       </div>
                   </div>
                   <!-- [ breadcrumb ] end -->
                    <div class="row">
                         <div class="col-lg-12">
                              <div class="card">
                                  <div class="card-body">
                                      <form id="FormAdd">
                                          <div class="row">
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">Order no.</label>
                                                      <input type="text" class="form-control" name="order_no" value="{{$order_no}}" readonly>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">สกุลเงิน</label>
                                                      <select class="form-control" name="currency_id" id="currency_id">
                                                           <option value>กรุณาเลือก</option>
                                                           @foreach ($currencies as $currency)
                                                                <option value="{{$currency->id}}">{{$currency->name}}</option>
                                                           @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">บริษัท</label>
                                                      <select class="form-control" name="company_id" id="company_id">
                                                           <option value>กรุณาเลือก</option>
                                                           @foreach ($companies as $company)
                                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                                           @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">วิธีการจัดส่ง</label>
                                                      <select class="form-control" name="shipping_id" id="shipping_id">
                                                           <option value>กรุณาเลือก</option>
                                                           @foreach ($shippings as $shipping)
                                                                <option value="{{$shipping->id}}">{{$shipping->name}}</option>
                                                           @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ค่าจัดส่ง</label>
                                                      <input type="text" class="form-control" name="shipping_cost" id="shipping_cost" value="" >
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ส่วนลด</label>
                                                      <input type="text" class="form-control" name="discount" id="discount" value="" >
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ลูกค้า</label>
                                                      <select class="form-control" name="customer_id" id="customer_id">
                                                           <option value>กรุณาเลือก</option>
                                                           @foreach ($customers as $customer)
                                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                           @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ชื่อ - นามสกุล</label>
                                                      <input type="text" class="form-control" name="customer_name" id="customer_name" value="" >
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ที่อยู่ในการจัดส่ง</label>
                                                      <textarea class="form-control" name="customer_address" id="customer_address"></textarea>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">เมือง</label>
                                                      <input type="text" class="form-control" name="customer_city" id="customer_city" value="" >
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">แขวง</label>
                                                      <select class="form-control" name="customer_id" id="customer_id">
                                                           <option value>กรุณาเลือก</option>
                                                           @foreach ($laos_districts as $laos_district)
                                                                <option value="{{$laos_district->id}}">{{$laos_district->name}}</option>
                                                           @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">เบอร์โทรศัพท์</label>
                                                      <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="" >
                                                  </div>
                                              </div>
                                          </div>
                                          <button type="submit" class="btn btn-primary">Submit</button>
                                      </form>
                                  </div>
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

     <script type="text/javascript">
         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
            });
         });

         $('#FormAdd').validate({
              ignore: '.ignore, .select2-input',
              focusInvalid: false,
              rules: {
                   // 'name' : {
                   //      required: true
                   // },
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
                        url : '{{ route('product.store') }}',
                        dataType : 'json',
                        data : formData,
                        processData: false,
                        contentType: false,
                   }).done(function(rec){
                        if (rec.status == 1) {
                             swal("", rec.content, "success").then(function(){
                                  window.location.href = "{{ route('order') }}";
                             });
                        } else {
                             swal("", rec.content, "warning");
                        }
                   }).fail(function(){

                   });
              },
              invalidHandler: function (form) {

              }
         });

         $('body').on('keyup','#price_bath',function(e){
              e.preventDefault();
              $.ajax({
                   method : "POST",
                   url : '{{ route('function.thb_to_lak') }}',
                   dataType : 'json',
                   data : {"thb" : $(this).val()}
              }).done(function(rec){
                   $("#price_lak").val( addNumformat((rec).toFixed(2)) );
              }).fail(function(){
                   swal("", "", "error");
              });
         });

     </script>
@endsection
