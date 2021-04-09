@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
@section('css_bottom')
     <style>

     </style>
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
                         <div class="col-md-4">
                              <div class="card">
                                   <div class="card-header">
                                        <h5>รายการสั่งซื้อ</h5>
                                        <span class="d-block m-t-5"></span>
                                        <hr style="border-top: 1px solid #999;"/>
                                   </div>
                                   <div class="card-body">
                                        <div class="col-md-12">
                                             <div class="form-group">
                                                  <label class="form-label">Order no.</label>
                                                  <input type="text" class="form-control" name="order_no" value="{{$order_no}}" readonly>
                                             </div>
                                        </div>
                                        <div class="col-md-12">
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
                                        <div class="col-md-12">
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
                                        <div class="col-md-12">
                                             <div class="form-group">
                                                  <label class="form-label">ส่วนลด</label>
                                                  <input type="text" class="form-control" name="discount" id="discount" value="" >
                                             </div>
                                        </div>
                                        <div class="col-md-12 mb-5">
                                             <div class="form-group">
                                                  <label class="form-label">โน็ต</label>
                                                  <textarea class="form-control" name="note" id="note"></textarea>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-md-8">
                              <div class="card">
                                   <div class="card-header">
                                        <h5>ข้อมูลลูกค้า</h5>
                                        <span class="d-block m-t-5"></span>
                                        <hr style="border-top: 1px solid #999;"/>
                                   </div>
                                   <div class="card-body">
                                        <div class="row">
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="customer_id">ลูกค้า</label>
                                                       <select class="js-example-basic-single form-control" name="customer_id" id="customer_id">
                                                            <option value>กรุณาเลือก</option>
                                                            @foreach ($customers as $customer)
                                                                 <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                            @endforeach
                                                       </select>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
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
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6">
                                                  <div class="form-group">
                                                       <label class="form-label">เมือง</label>
                                                       <input type="text" class="form-control" name="customer_city" id="customer_city" value="" >
                                                  </div>
                                             </div>
                                             <div class="col-md-6">
                                                  <div class="form-group">
                                                       <label class="form-label">แขวง</label>
                                                       <select class="js-example-basic-single form-control" name="laos_distict_id" id="laos_distict_id">
                                                            <option value>กรุณาเลือก</option>
                                                            @foreach ($laos_districts as $laos_district)
                                                                 <option value="{{$laos_district->id}}">{{$laos_district->name}}</option>
                                                            @endforeach
                                                       </select>
                                                  </div>
                                             </div>

                                        </div>
                                        <div class="row">
                                             <div class="col-md-6">
                                                  <div class="form-group">
                                                       <label class="form-label">เบอร์โทรศัพท์</label>
                                                       <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="" >
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="card-header">
                                        <h5>วิธีการจัดส่ง</h5>
                                        <span class="d-block m-t-5"></span>
                                        <hr style="border-top: 1px solid #999;"/>
                                   </div>
                                   <div class="card-body">
                                        <div class="row">
                                             <div class="col-md-6">
                                                  <div class="form-group">
                                                       <label class="form-label">วิธีการจัดส่ง</label>
                                                       <select class="js-example-basic-single form-control" name="shipping_id" id="shipping_id">
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
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="col-md-12">
                              <div class="card">
                                   <div class="card-header">
                                        <h5>สินค้า</h5>
                                        <span class="d-block m-t-5"></span>
                                        <hr style="border-top: 1px solid #999;"/>
                                   </div>
                                   <div class="card-body">
                                        <div class="dt-responsive table-responsive">
                                             <table id="scr-vrt-dt" class="table table-striped table-bordered nowrap">
                                                  <thead>
                                                       <tr>
                                                            <th class="border-top-0">ภาพ</th>
                                                            <th class="border-top-0">SKU</th>
                                                            <th class="border-top-0">ชื่อ</th>
                                                            <th class="border-top-0">ราคาขาย(บาท)</th>
                                                            <th class="border-top-0">ราคาขาย(กีบ)</th>
                                                            <th class="border-top-0">ประเภท</th>
                                                            <th class="border-top-0">จำนวนคงเหลือในโกดัง</th>
                                                            <th class="border-top-0">action</th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       @foreach ($products as $key => $product)
                                                            <tr>
                                                                 <td>
                                                                      <div class="d-inline-block align-middle">
                                                                           <img src="{{ isset($product->image) ? asset('uploads/products/'.$product->image) : asset('assets/images/product/prod-0.jpg')}}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
                                                                      </div>
                                                                 </td>
                                                                 <td>{{$product->sku}}</td>
                                                                 <td>{{$product->name}}</td>
                                                                 <td>{{$product->price_bath}}</td>
                                                                 <td>{{$product->price_lak}}</td>
                                                                 <td>{{$product->ProductType->name}}</td>
                                                                 <td>{{ isset($product->in_stock) ? $product->in_stock : 0 }}</td>
                                                                 <td>
                                                                      {{-- <div class="btn-group">
                                                                           <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[{{$key}}]">
                                                                                <span class="fas fa-minus-circle"></span>
                                                                           </button>
                                                                           <input type="text" name="quant[{{$key}}]" class="w-25 input-number" value="0" min="0" max="100">
                                                                           <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[{{$key}}]">
                                                                                <span class="fas fa-plus-circle"></span>
                                                                           </button>
                                                                      </div> --}}
                                                                      <div class="btn-group" role="group" aria-label="Basic example">
                                                                           <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[{{$key}}]">
                                                                                <span class="fas fa-minus-circle"></span>
                                                                           </button>
                                                                           <input type="text" name="quant[{{$key}}]" class="w-25 input-number" value="0" min="0" max="100">
                                                                           <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[{{$key}}]">
                                                                                <span class="fas fa-plus-circle"></span>
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

                    <div class="row">
                         <div class="col-lg-12">
                              <div class="card">
                                   <div class="card-body">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
     <!-- datatable Js -->
     <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>
     <!-- select2 Js -->
     <script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
     <script type="text/javascript">
         $(document).ready(function() {

              $(".js-example-basic-single").select2();

              $("#pcoded").pcodedmenu({
                   themelayout: 'horizontal',
                   MenuTrigger: 'hover',
                   SubMenuTrigger: 'hover',
              });

              $('.btn-number').click(function(e){
                   e.preventDefault();

                   fieldName = $(this).attr('data-field');
                   type      = $(this).attr('data-type');
                   var input = $("input[name='"+fieldName+"']");
                   var currentVal = parseInt(input.val());
                   if (!isNaN(currentVal)) {
                        if(type == 'minus') {

                             if(currentVal > input.attr('min')) {
                                  input.val(currentVal - 1).change();
                             }
                             if(parseInt(input.val()) == input.attr('min')) {
                                  $(this).attr('disabled', true);
                             }

                        } else if(type == 'plus') {

                             if(currentVal < input.attr('max')) {
                                  input.val(currentVal + 1).change();
                             }
                             if(parseInt(input.val()) == input.attr('max')) {
                                  $(this).attr('disabled', true);
                             }

                        }
                   } else {
                        input.val(0);
                   }
              });
              $('.input-number').focusin(function(){
                   $(this).data('oldValue', $(this).val());
              });
              $('.input-number').change(function() {

                   minValue =  parseInt($(this).attr('min'));
                   maxValue =  parseInt($(this).attr('max'));
                   valueCurrent = parseInt($(this).val());

                   name = $(this).attr('name');
                   if(valueCurrent >= minValue) {
                        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
                   } else {
                        alert('Sorry, the minimum value was reached');
                        $(this).val($(this).data('oldValue'));
                   }
                   if(valueCurrent <= maxValue) {
                        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
                   } else {
                        alert('Sorry, the maximum value was reached');
                        $(this).val($(this).data('oldValue'));
                   }


              });
              $(".input-number").keydown(function (e) {
                   // Allow: backspace, delete, tab, escape, enter and .
                   if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                   // Allow: Ctrl+A
                   (e.keyCode == 65 && e.ctrlKey === true) ||
                   // Allow: home, end, left, right
                   (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                   }
                   // Ensure that it is a number and stop the keypress
                   if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                   }
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
