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
                         <div class="col-lg-12">
                              <div class="card">
                                  <div class="card-body">
                                      <form id="FormAdd">
                                          <div class="row">
                                               <div class="col-md-12 text-center">
                                                   <div class="form-group">
                                                       <img id="preview_img" src="{{asset('assets/images/product/prod-0.jpg')}}" alt="" style=" height: 100px; width: 100px;" />
                                                       <div class="mt-3">
                                                            <input type="file" onchange="readURL(this);" class="btn-warning" name="image">
                                                       </div>
                                                   </div>
                                               </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">SKU</label>
                                                      <input type="text" class="form-control" name="sku" value="{{$qty}}" readonly>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ชื่อสินค้า</label>
                                                      <input type="text" class="form-control" name="name" placeholder="">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">ประเภทสินค้า</label>
                                                      <select class="form-control" name="product_type">
                                                           <option value>กรุณาเลือก</option>
                                                           @foreach ($product_types as $product_type)
                                                                <option value="{{$product_type->id}}">{{$product_type->name}}</option>
                                                           @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">บริษัท</label>
                                                      <select class="form-control" name="company">
                                                           <option value>กรุณาเลือก</option>
                                                           @foreach ($companies as $company)
                                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                                           @endforeach
                                                      </select>
                                                  </div>
                                              </div>

                                              @foreach ($currencies as $currency)
                                                   <div class="col-md-6">
                                                        <div class="form-group">
                                                           <label class="form-label">ราคา({{$currency->name_th}})</label>
                                                           <input type="text" class="form-control" name="{{$currency->variable}}" id="{{$currency->variable}}">
                                                       </div>
                                                   </div>
                                              @endforeach
                                              {{-- <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ราคา(บาท)</label>
                                                      <input type="text" class="form-control number-only" name="price_bath" id="price_bath" >
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ราคา(กีบ)</label>
                                                      <input type="text" class="form-control" name="price_lak" id="price_lak">
                                                  </div>
                                              </div> --}}
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <div class="switch d-inline m-r-10">
                                                          <input type="checkbox" class="switcher-input" name="use_flag" value="Y" id="switch-1" checked>
                                                          <label for="switch-1" class="cr"></label>
                                                      </div>
                                                      <label>ใช้งาน</label>
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
                   'name' : {
                        required: true
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
                        url : '{{ route('product.store') }}',
                        dataType : 'json',
                        data : formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                             $("#preloaders").css("display", "block");
                        },
                   }).done(function(rec){
                        $("#preloaders").css("display", "none");
                        if (rec.status == 1) {
                             swal("", rec.content, "success").then(function(){
                                  window.location.href = "{{ route('product') }}";
                             });
                        } else {
                             swal("", rec.content, "warning");
                        }
                   }).fail(function(){
                        $("#preloaders").css("display", "none");
                   });
              },
              invalidHandler: function (form) {

              }
         });

         function readURL(input) {
              if (input.files && input.files[0]) {
                   var reader = new FileReader();
                   reader.onload = function (e) {
                        $('#preview_img').attr('src', e.target.result);
                   }
                   reader.readAsDataURL(input.files[0]);
              }
         }

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
