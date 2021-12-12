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
                                        <button type="button" class="btn waves-effect waves-light btn-primary m-0" data-toggle="modal" data-target="#exampleModal">
                                           เพิ่มเมนู
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                           <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel2"><i class="feather icon-user mr-1"></i>เพิ่มเมนู</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="FormAdd">
                                                        <div class="modal-body text-left">
                                                            <div class="form-group">
                                                               <label>ชื่อเมนู</label>
                                                               <input type="text" class="form-control" name="menu_name" placeholder="">
                                                            </div>
                                                            {{-- <div class="form-group">
                                                               <label>Icon</label>
                                                               <input type="text" class="form-control" name="icon" placeholder="">
                                                            </div> --}}
                                                            {{-- <div class="form-group">
                                                               <label>Link</label>
                                                               <input type="text" class="form-control" name="link" placeholder="">
                                                            </div> --}}
                                                            <div class="form-group">
                                                                 <div class="switch d-inline m-r-10">
                                                                      <input type="checkbox" checked class="switcher-input" name="use_flag" value="Y">
                                                                      <label for="use_flag" class="cr"></label>
                                                                 </div>
                                                                 <label>ใช้งาน</label>
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
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                           <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><i class="feather icon-user mr-1"></i>แก้ไข</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="FormEdit">
                                                        <div class="modal-body text-left">
                                                            <div class="form-group">
                                                               <label>ชื่อเมนู</label>
                                                               <input type="hidden" class="form-control" id="menu_id" name="menu_id">
                                                               <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="">
                                                            </div>
                                                            {{-- <div class="form-group">
                                                               <label>Icon</label>
                                                               <input type="text" class="form-control" id="icon" name="icon" placeholder="">
                                                            </div> --}}
                                                            {{-- <div class="form-group">
                                                               <label>Link</label>
                                                               <input type="text" class="form-control" id="link" name="link" placeholder="">
                                                            </div> --}}
                                                            <div class="form-group">
                                                                 <div class="switch d-inline m-r-10">
                                                                      <input type="checkbox"  class="switcher-input" id="use_flag" name="use_flag" value="Y">
                                                                      <label for="use_flag" class="cr"></label>
                                                                 </div>
                                                                 <label>ใช้งาน</label>
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
                                        <!-- end Modal edit -->
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
                                                <th class="border-top-0">สถานะ</th>
                                                <th class="border-top-0">action</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($menus as $key => $menu)
                                                  <tr>
                                                       <td>{{$menu->name}}</td>
                                                       <td>
                                                            @if ($menu->use_flag == 'Y')
                                                                 <span class="badge bg-success text-dark">ใช้งาน</span>
                                                            @else
                                                                 <span class="badge bg-danger text-dark">ไม่ใช้งาน</span>
                                                            @endif
                                                       </td>
                                                       <td>
                                                            <div class="btn-group btn-group-sm">
                                                                 <button class="btn btn-warning btn-edit text-white" data-value="{{$menu->id}}" data-toggle="modal" data-target="#ModalEdit">
                                                                      <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                 </button>
                                                                 <button class="btn btn-danger btn-delete text-white" data-value="{{$menu->id}}">
                                                                      <i class="ace-icon feather icon-trash-2 bigger-120"></i>
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

         $('#FormAdd').validate({
             errorElement: 'div',
             errorClass: 'invalid-feedback',
             focusInvalid: false,
             rules: {
                 name :{
                     required: true,
                 },
             },
             messages: {
                 name :{
                     required: "กรุณาระบุ",
                 },
             },
             highlight: function (e) {
                 validate_highlight(e);
             },
             success: function (e) {
                 validate_success(e);
             },
             errorPlacement: function (error, element) {
                 validate_errorplacement(error, element);
             },
             submitHandler: function (form) {
                 var btn = $("#FormAdd").find('[type="submit"]');
                 btn.button("loading");
                 $.ajax({
                     method : "POST",
                     url : '{{ route('menu.store') }}',
                     dataType : 'json',
                     data : $("#FormAdd").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 }).done(function(rec){
                     btn.button("reset");
                     if (rec.status == 1) {
                          swal("", rec.content, "success").then(function(){
                               window.location.href = "{{ route('menu') }}";
                          });
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

         $('#FormEdit').validate({
             errorElement: 'div',
             errorClass: 'invalid-feedback',
             focusInvalid: false,
             rules: {
                 name :{
                     required: true,
                 },
             },
             messages: {
                 name :{
                     required: "กรุณาระบุ",
                 },
             },
             highlight: function (e) {
                 validate_highlight(e);
             },
             success: function (e) {
                 validate_success(e);
             },
             errorPlacement: function (error, element) {
                 validate_errorplacement(error, element);
             },
             submitHandler: function (form) {
                 var btn = $("#FormEdit").find('[type="submit"]');
                 btn.button("loading");
                 $.ajax({
                     method : "POST",
                     url : url_gb + '/admin/menu/update',
                     dataType : 'json',
                     data : $("#FormEdit").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 }).done(function(rec){
                      btn.button("reset");
                      if (rec.status == 1) {
                           swal("", rec.content, "success").then(function(){
                                window.location.href = "{{ route('menu') }}";
                           });
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

         $('body').on('click', '.btn-edit', function (e) {
              e.preventDefault();
              var data = $(this).data('value');
              $.ajax({
                   method : "get",
                   url : url_gb + '/admin/menu/' + data,
                   dataType : 'json',
                   beforeSend: function() {
                        $("#preloaders").css("display", "block");
                   },
              }).done(function(rec){
                   $("#menu_id").val(data);
                   $("#menu_name").val(rec.name);
                    $("#icon").val(rec.icon);
                    $("#link").val(rec.link);
                    if (rec.use_flag == 'Y') {
                         $("#use_flag").prop("checked", true);
                    } else {
                         $("#use_flag").prop("checked", false);
                    }
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
                                method : "delete",
                                url : url_gb + '/admin/menu/' + $(this).data("value"),
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
                                         window.location.href = "{{ route('menu') }}";
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
