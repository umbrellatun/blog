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
                                           เพิ่ม{{$titie}}
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
                                                               <label>ชื่อบทบาท</label>
                                                               <input type="text" class="form-control" name="menu_name" placeholder="">
                                                            </div>
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
                                                               <label>ชื่อบทบาท</label>
                                                               <input type="hidden" class="form-control" id="menu_id" name="menu_id">
                                                               <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="">
                                                            </div>
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
                                                <th class="border-top-0">ชื่อบทบาท</th>
                                                <th class="border-top-0">สถานะ</th>
                                                <th class="border-top-0">action</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($roles as $key => $role)
                                                  <tr>
                                                       <td>{{$role->name}}</td>
                                                       <td>
                                                            @if ($role->use_flag == 'Y')
                                                                 <span class="badge bg-success text-dark">ใช้งาน</span>
                                                            @else
                                                                 <span class="badge bg-danger text-dark">ไม่ใช้งาน</span>
                                                            @endif
                                                       </td>
                                                       <td>
                                                            <div class="btn-group btn-group-sm">
                                                                 <button class="btn btn-warning btn-edit text-white" data-value="{{$role->id}}" data-toggle="modal" data-target="#ModalEdit">
                                                                      <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                 </button>
                                                                 <button class="btn btn-danger btn-delete text-white" data-value="{{$role->id}}">
                                                                      <i class="ace-icon feather icon-trash-2 bigger-120"></i>
                                                                 </button>
                                                                 <button class="btn btn-primary btn-permission text-white" data-value="{{$role->id}}">
                                                                      <i class="fa fa-lock" aria-hidden="true"></i>
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
     <div id="permissionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                    <form id="form_permission">
                         <div class="modal-body">
                              <div class="card">
                                   <div class="dt-responsive table-responsive">
                                        <table id="permissionTable" class="table table-striped table-bordered nowrap">
                                             <thead>
                                                  <tr>
                                                       <th class="border-top-0">ชื่อเมนู</th>
                                                       <th class="border-top-0"><input type="checkbox" class="check_all"></th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>
                         </div>
                         <div class="modal-footer">
                              <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>บันทึก</button>
                              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                         </div>
                         <input type="hidden" name="role_id" id="role_id">
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
          function inArray(needle, haystack) {
               var length = haystack.length;
               for(var i = 0; i < length; i++) {
                    if(typeof haystack[i] == 'object') {
                         if(arrayCompare(haystack[i], needle)) return true;
                    } else {
                         if(haystack[i] == needle) return true;
                    }
               }
               return false;
          }


         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
            });
         });

         $('body').on('change', '.check_all', function (e) {
              e.preventDefault();
              if ($(this).prop("checked") == true) {
                   $(".menu_check").prop("checked", true);
              } else {
                   $(".menu_check").prop("checked", false);
              }
         });

         $('body').on('change', '.menu_check', function (e) {
              e.preventDefault();
              order_arr = [];
              $(".menu_check").each(function(i, obj) {
                   order_arr.push($(this).prop("checked"));
              });
              if(inArray(false, order_arr)){
                   $(".check_all").prop("checked", false);
              } else {
                   $(".check_all").prop("checked", true);
              }
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
                     url : '{{ route('role.store') }}',
                     dataType : 'json',
                     data : $("#FormAdd").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 }).done(function(rec){
                     btn.button("reset");
                     if (rec.status == 1) {
                          swal("", rec.content, "success").then(function(){
                               window.location.href = "{{ route('role') }}";
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
                     url : url_gb + '/admin/role/update',
                     dataType : 'json',
                     data : $("#FormEdit").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 }).done(function(rec){
                      btn.button("reset");
                      if (rec.status == 1) {
                           swal("", rec.content, "success").then(function(){
                                window.location.href = "{{ route('role') }}";
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
                   url : url_gb + '/admin/role/' + data,
                   dataType : 'json',
                   beforeSend: function() {
                        $("#preloaders").css("display", "block");
                   },
              }).done(function(rec){
                   $("#menu_id").val(data);
                   $("#menu_name").val(rec.name);
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

         $('body').on('click', '.btn-permission', function (e) {
              e.preventDefault();
              var data = $(this).data('value');
              $.ajax({
                   method : "get",
                   url : url_gb + '/admin/role/permission/' + data,
                   dataType : 'json',
                   beforeSend: function() {
                        $("#preloaders").css("display", "block");
                        $(".check_all").prop("checked", false);
                        $(".menu_check").prop("checked", false);
                        $("#role_id").val('');
                        $("#permissionTable tbody").empty();
                   },
              }).done(function(rec){
                   $("#preloaders").css("display", "none");
                   if (rec.status == 1){
                        $("#role_id").val(data);
                        let html = '';
                        let checked1 = '';
                        let checked2 = '';
                        $.each(rec.menus, function( index, menu ) {
                             html += '<tr>';
                             html += '<td>';
                             html += menu.name;
                             html += '<input type="hidden" name="menu_id['+menu.id+']" value="'+menu.id+'">';
                             html += '</td>';
                             html += '<td>';
                             if (menu.permission){
                                  if (menu.permission.menu_permission == 'T') {
                                       checked1 = 'checked';
                                  } else {
                                       checked1 = '';
                                  }
                             } else {
                                  checked1 = '';
                             }
                             html += '<input type="checkbox" name="menu_chk['+menu.id+']" class="form-input menu_check" '+checked1+' value="T">';
                             html += '</td>';
                             html += '</tr>';
                             $.each(menu.sub_menu, function( index, sub_menu ) {
                                  html += '<tr>';
                                  html += '<td><span class="ml-5">';
                                  html += sub_menu.name;
                                  html += '<input type="hidden" name="sub_menu_id['+sub_menu.id+']" value="'+sub_menu.id+'">';
                                  html += '</span>';
                                  html += '</td>';
                                  html += '<td>';
                                  if (sub_menu.permission){
                                       if (sub_menu.permission.submenu_permission == 'T') {
                                            checked2 = 'checked';
                                       } else {
                                            checked2 = '';
                                       }
                                  } else {
                                       checked2 = '';
                                  }
                                  html += '<input type="checkbox" name="sub_menu_chk['+sub_menu.id+']" class="form-input menu_check" '+checked2+' value="T">';
                                  html += '</td>';
                                  html += '</tr>';
                             });
                        });
                        $("#permissionTable tbody").html(html);
                   }
                   $("#permissionModal").modal('show');
              }).fail(function(){
                   $("#preloaders").css("display", "none");
                   swal("", rec.content, "error");
              });
         });

         $('#form_permission').validate({
             errorElement: 'div',
             errorClass: 'invalid-feedback',
             focusInvalid: false,
             rules: {

             },
             messages: {

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
                 var btn = $("#form_permission").find('[type="submit"]');
                 btn.button("loading");
                 $.ajax({
                     method : "POST",
                     url : '{{ route('role.storepermision') }}',
                     dataType : 'json',
                     data : $("#form_permission").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 }).done(function(rec){
                     btn.button("reset");
                     if (rec.status == 1) {
                          swal("", rec.content, "success").then(function(){
                               window.location.href = "{{ route('role') }}";
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
                                // url : url_gb + '/admin/role/' + $(this).data("value"),
                                method : "post",
                                url : '{{ route('role.destroy') }}',
                                data : {"role_id" : $(this).data("value")},
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
                                         window.location.href = "{{ route('role') }}";
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
