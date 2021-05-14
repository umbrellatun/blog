@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
         <div class="col-sm-12">
             <div class="card">
                 <div class="card-header">
                    <h5>ตั้งค่าค่าแพ็ค</h5>
                 </div>
                 <div class="card-body">
                      <div class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                     <div class="modal-header">
                                          <h5 class="modal-title h4" id="mySmallModalLabel">ค่าแพ็ค</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                     </div>
                                     <form id="FormAdd">
                                          <div class="modal-body">
                                               <div class="row">
                                                    <div class="col-md-12">
                                                         <div class="form-group form-inline">
                                                              <label>ค่าแพ็ค</label>
                                                              <input type="text" class="ml-2 form-control" id="price" name="price" value="{{$setting->price}}" required>
                                                         </div>
                                                    </div>

                                               </div>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal">ปิด</button>
                                              <button type="submit" class="btn waves-effect waves-light btn-primary"><i class="fas fa-save"></i> บันทึก</button>
                                          </div>
                                     </form>
                                </div>
                           </div>
                      </div>
                      <div class="row">
                           <div class="col-md-6 col-xl-3">
                                <div class="card bg-c-green">
                                     <div class="card-body">
                                          <h5 class="text-white">ค่าแพ็ค</h5>
                                          <h5 class="text-white"><span class="float-right">{{number_format($setting->price, 2)}} THB</span></h5>
                                          <div class="text-center">
                                               <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fas fa-cog"></i></button>
                                          </div>
                                     </div>
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
     <!-- datatable Js -->
     <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>

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
             errorElement: 'div',
             errorClass: 'invalid-feedback',
             focusInvalid: false,
             rules: {
                 lak :{
                     required: true,
                 },
             },
             messages: {
                 lak :{
                     required: "กรุณาระบุ",
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
                       // $el.parent().focus();
                  }
                  // $el.focus();
                  // $(window).scrollTop($('.is-invalid').offset().top);
                  // $("html, body").delay(300).animate({
                  //      scrollTop: $el.offset().top
                  // }, 2000);
             },
             unhighlight: function(element) {
                  $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
             },
             submitHandler: function (form) {
                 var btn = $("#FormAdd").find('[type="submit"]');
                 $.ajax({
                     method : "POST",
                     url : '{{ route('ratepack.update') }}',
                     dataType : 'json',
                     data : $("#FormAdd").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     },
                     beforeSend: function() {
                          $("#preloaders").css("display", "block");
                     },
                 }).done(function(rec){
                     if (rec.status == 1) {
                          swal("", rec.content, "success").then(function(){
                               window.location.href = "{{ route('ratepack') }}";
                          });
                     } else {
                          swal("", rec.content, "warning");
                     }
                     $("#preloaders").css("display", "none");
                 }).fail(function(){
                     btn.button("reset");
                     $("#preloaders").css("display", "none");
                 });
             },
             invalidHandler: function (form) {

             }
         });

     </script>
@endsection
