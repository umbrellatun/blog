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
                                         <a href="{{ route('user.create') }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus"></i> เพิ่มผู้ใช้งาน</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-none">
                            <div class="card-body shadow border-0">
                                <div class="dt-responsive table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered nowrap">
                                        <thead>
                                           <tr>
                                                <th class="border-top-0">ชื่อเมนู</th>
                                                <th class="border-top-0">บริษัท / ชื่อร้านค้า</th>
                                                <th class="border-top-0">บทบาท</th>
                                                <th class="border-top-0">สถานะ</th>
                                                <th class="border-top-0">action</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($users as $key => $user)
                                                  <tr>
                                                       <td>
                                                            <div class="d-inline-block align-middle">
                                                                 <img src="{{ !empty($user->profile_image) ? asset('uploads/users/'.$user->profile_image) : asset('assets/images/user/avatar.png')}}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
                                                                 <div class="d-inline-block">
                                                                      <h6 class="m-b-0">{{$user->name}} {{$user->lastname}}</h6>
                                                                      <p class="m-b-0">{{$user->email}}</p>
                                                                 </div>
                                                            </div>

                                                       </td>
                                                       <td>{{ ($user->Company ? $user->Company->name : '') }}</td>
                                                       <td>{{ ($user->Role ? $user->Role->name : '') }}</td>
                                                       <td>
                                                            @if ($user->use_flag == 'Y')
                                                                 <span class="badge bg-success text-dark">ใช้งาน</span>
                                                            @else
                                                                 <span class="badge bg-danger text-dark">ไม่ใช้งาน</span>
                                                            @endif
                                                       </td>
                                                       <td>
                                                            <div class="btn-group btn-group-sm">
                                                                 <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-warning btn-edit text-white">
                                                                      <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                 </a>
                                                                 <button class="btn btn-danger btn-delete text-white" data-value="{{$user->id}}">
                                                                      <i class="ace-icon feather icon-trash-2 bigger-120"></i>
                                                                 </button>
                                                                 <button class="btn btn-primary btn-password" data-id="{{$user->id}}" data-user="{{$user->id}}" title="รีเซ็ตรหัสผ่าน" data-toggle="modal" data-target="#ModalEdit">
                                                                      <i class="fas fa-key"></i>
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
           </div>
       </div>
   </div>
@endsection
@section('modal')
     <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel"><i class="feather icon-user mr-1"></i>แก้ไขรหัสผ่าน</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <form id="FormResetPassword">
                         <div class="modal-body text-left">
                              <div class="form-group">
                                   <label>ชื่อผู้ใช้งาน</label>
                                   <input type="hidden" class="form-control" id="reset_user_id" name="user_id">
                                   <input type="text" class="form-control" id="reset_email" style="cursor: no-drop" disabled>
                              </div>
                              <div class="form-group">
                                   <label>รหัสผ่าน</label>
                                   <input type="password" class="form-control" id="reset_password" name="password" placeholder="">
                              </div>
                              <div class="form-group">
                                   <label>ยืนยันรหัสผ่าน</label>
                                   <input type="password" class="form-control" id="reset_password_confirm" name="password_confirm" placeholder="">
                              </div>
                         </div>
                         <div class="modal-footer">
                              <button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i>ปิด</button>
                              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> บันทึก</button>
                         </div>
                    </form>
               </div>
          </div>
     </div>
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

         $('#FormResetPassword').validate({
              ignore: '.ignore, .select2-input',
              focusInvalid: false,
              rules: {
                   'password' : {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                   },
                   'password_confirm' : {
                        required: true,
                        minlength: 6,
                        equalTo: 'input[name="password"]'
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
                   var btn = $("#FormResetPassword").find('[type="submit"]');
                   btn.button("loading");
                   $.ajax({
                        method : "POST",
                        url : url_gb+"/admin/user/reset_password",
                        dataType : 'json',
                        data : $("#FormResetPassword").serialize(),
                   }).done(function(rec){
                        btn.button("reset");
                        if (rec.status == 1) {
                             $("#ModalEdit").modal('hide');
                        } else {
                             swal("", rec.content, "warning");
                        }
                   }).fail(function(){
                        btn.button("reset");
                   });
              },
              invalidHandler: function (form) {

              }
         });

         $('body').on('click', '.btn-password', function (e) {
              e.preventDefault();
              var data = $(this).data('id');
              $("#reset_email").val("");
              $("#reset_user_id").val("");
              $("#reset_password").val("");
              $("#reset_password_confirm").val("");
              $.ajax({
                   method : "get",
                   url : url_gb + '/admin/user/' + data,
                   dataType : 'json',
                   beforeSend: function() {
                        $("#preloaders").css("display", "block");
                   },
              }).done(function(rec){
                    $("#reset_user_id").val(rec.id);
                    $("#reset_email").val(rec.email);
                   $("#preloaders").css("display", "none");
              }).fail(function(){
                   $("#preloaders").css("display", "none");
                   swal("", rec.content, "error");
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
                             // method : "delete",
                             // url : url_gb + '/admin/user/' + $(this).data("value"),
                             method : "post",
                             url : '{{ route('user.destroy') }}',
                             data: {"user_id" : $(this).data("value")},
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
