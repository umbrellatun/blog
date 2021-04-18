@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
@section('css_bottom')
     <style>
     .div_time {
          /* background-color: #adb7be; */
          /* display: inline-flex; */
          /* border: 1px solid #ccc; */
          /* color: #555; */
     }

     .input_time {
          background-color: #343a40;
          border: none;
          color: #adb7be;
          text-align: center;
          width: 100px;
          height: 25px;
     }
     </style>
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
                                     <li class="breadcrumb-item"><a href="{{route('order.manage', ['id' => $transfer->Order->id])}}">จัดการคำสั่งซื้อ</a></li>
                                     <li class="breadcrumb-item">{{$titie}}</li>
                                </ul>
                           </div>
                      </div>
                 </div>
            </div>
            <!-- [ breadcrumb ] end -->
           <div class="page-wrapper">
                <div class="row">
                    <!-- [ file-upload ] start -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>อัพโหลดหลักฐานการโอน</h5>
                            </div>
                            <div class="card-body">
                                <form id="FormAdd">
                                     <div class="row">
                                          <div class="col-md-12 text-center">
                                             <div class="form-group">
                                                  <img id="preview_img" src="{{asset('uploads/transfers/' . $transfer->image)}}" alt="" style=" height: 500px; width: 500px;" />
                                                  <div class="mt-3">
                                                       <input type="file" onchange="readURL(this);" class="btn-warning" name="image">
                                                  </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                               <div class="form-group">
                                                  <label class="form-label">ยอดที่โอน</label>
                                                  <input type="text" class="form-control" name="price" value="{{$transfer->amount}}" autocomplete="off" >
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="form-label">สกุลเงิน</label>
                                                    <select class="form-control" name="currency_id" id="currency_id">
                                                         <option value>กรุณาเลือก</option>
                                                         @foreach ($currencies as $currency)
                                                              @if ($currency->id == $transfer->currency_id)
                                                                   @php
                                                                        $selected = 'selected';
                                                                   @endphp
                                                              @else
                                                                   @php
                                                                        $selected = '';
                                                                   @endphp
                                                              @endif
                                                              <option value="{{$currency->id}}" {{$selected}}>{{$currency->name}}</option>
                                                         @endforeach
                                                    </select>
                                               </div>
                                          </div>
                                          <div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="form-label">วันที่โอน</label>
                                                    <input type="text" name="transfer_date" value="{{$transfer->transfer_date}}" class="form-control" />
                                               </div>
                                          </div>
                                          <div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="form-label">เวลาที่โอน</label>
                                                    <div class="div_time form-control">
                                                         <select name="hours" id="hours" class="input_time">
                                                              <option value>ชั่วโมง</option>
                                                              @for ($i=1;$i<24;$i++)
                                                                   @if ($transfer->transfer_hours == $i)
                                                                        @php
                                                                             $selected = 'selected';
                                                                        @endphp
                                                                   @else
                                                                        @php
                                                                             $selected = '';
                                                                        @endphp
                                                                   @endif
                                                                   <option value="{{$i}}" {{$selected}}>{{$i}}</option>
                                                              @endfor
                                                         </select>
                                                         <select name="minutes" id="minutes" class="input_time">
                                                              <option value>นาที</option>
                                                              @for ($i=1;$i<60;$i++)
                                                                   @if ($transfer->transfer_minutes == $i)
                                                                        @php
                                                                             $selected = 'selected';
                                                                        @endphp
                                                                   @else
                                                                        @php
                                                                             $selected = '';
                                                                        @endphp
                                                                   @endif
                                                                   <option value="{{$i}}" {{$selected}}>{{$i}}</option>
                                                              @endfor
                                                         </select>
                                                    </div>
                                               </div>
                                          </div>
                                          <div class="col-md-6">
                                               <div class="form-group">
                                                    <label class="form-label">โน็ต</label>
                                                    <textarea class="form-control" name="note">{{$transfer->remark}}</textarea>
                                               </div>
                                          </div>
                                     </div>
                                     @if ($transfer->status == 'W')
                                          <div class="text-center m-t-20">
                                              <button id="btn-upload" class="btn btn-primary">อัพโหลด</button>
                                          </div>
                                     @endif
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- [ file-upload ] end -->
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
     <!-- datepicker js -->
     <script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>
     {{-- <script src="assets/js/pages/ac-datepicker.js"></script> --}}
     <script type="text/javascript">
         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
            });
         });

         $(function() {
              $('input[name="transfer_date"]').daterangepicker({
                   singleDatePicker: true,
                   showDropdowns: true,
                   minYear: 2020,
                   maxYear: parseInt(moment().format('YYYY'),10),
                   locale: {
                      format: 'DD MMM YYYY'
                  }
              });
         });

         $('#FormAdd').validate({
              ignore: '.ignore, .select2-input',
              focusInvalid: false,
              rules: {
                   'price' : {
                        required: true
                   },
                   'currency_id' : {
                        required: true
                   },
                   'transfer_date' : {
                        required: true
                   },
                   'minutes' : {
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
                        url : '{{ route('transfer.update', ['transfer_id' => $transfer->Order->id]) }}',
                        dataType : 'json',
                        data : formData,
                        processData: false,
                        contentType: false,
                   }).done(function(rec){
                        if (rec.status == 1) {
                             swal("", rec.content, "success").then(function(){
                                  window.location.href = "{{ route('transfer', ['order_id' => $transfer->Order->id]) }}";
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

         function readURL(input) {
              if (input.files && input.files[0]) {
                   var reader = new FileReader();
                   reader.onload = function (e) {
                        $('#preview_img').attr('src', e.target.result);
                   }
                   reader.readAsDataURL(input.files[0]);
              }
         }



     </script>
@endsection
