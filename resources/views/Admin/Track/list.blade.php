@extends('layouts.layout')
<!-- rangeslider css -->
{{-- <link rel="stylesheet" href="{{asset('assets/css/plugins/bootstrap-slider.min.css')}}"> --}}
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
                                         <h5 class="m-b-10"><i class="fas fa-truck mr-2"></i>{{$title}} {{$order->order_no}}</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                         <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                                         <li class="breadcrumb-item"><a href="{{route('order')}}">รายการสั่งซื้อ</a></li>
                                         <li class="breadcrumb-item"><a href="{{route('order.manage', ['id' => $order->id])}}">จัดการคำสั่งซื้อ</a></li>
                                         <li class="breadcrumb-item">{{$title}}</li>
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
                                         <h5>Tracking number</h5>
                                         <hr/>
                                         <div class="form-group mb-2 col-12">
                                              <input type="text" id="tracking_number" name="tracking_number" class="form-control" placeholder="กรอก Tracking number ที่นี่">
                                         </div>
                                    </div>
                                    <div class="card-footer">
                                         <div class="form-group mb-2 col-12">
                                              <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-save mr-2"></i>บันทึก</button>
                                         </div>
                                    </div>
                               </div>
                          </div>
                          {{-- <div class="col-xl-12 col-md-12">
           				<div class="card">
           					<div class="card-body">
           						<h6>Create an input element wth the data-provide="slider" attribute automatically turns it into a slider. Options can be supplied via data-slider- attributes.</h6>
           						<hr>
           						<input id="ex21" type="text" data-provide="slider" data-slider-ticks="[1, 2, 3]" data-slider-ticks-labels='["short", "medium", "long"]' data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="3"
           							data-slider-tooltip="hide" />
           					</div>
           				</div>
           			</div> --}}

                     </div>
                </form>
           </div>
       </div>
   </div>
@endsection
@section('modal')

@endsection
@section('js_bottom')
     <!-- jquery-validation Js -->
     <script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
     <!-- sweet alert Js -->
     <script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>
     <!-- range slider Js -->
     {{-- <script src="{{asset('assets/js/plugins/bootstrap-slider.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/ac-rangeslider.js')}}"></script> --}}
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
                   'tracking_number' : {
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
                   $.ajax({
                        method : "POST",
                        url : '{{ route('track.update', ['order_id' => $order->id]) }}',
                        dataType : 'json',
                        data : $("#FormAdd").serialize(),
                   }).done(function(rec){
                        // if (rec.status == 1) {
                        //      swal("", rec.content, "success").then(function(){
                        //           window.location.href = "{{ route('order') }}";
                        //      });
                        // } else {
                        //      swal("", rec.content, "warning");
                        // }
                   }).fail(function(){

                   });
              },
              invalidHandler: function (form) {

              }
         });

     </script>
@endsection
