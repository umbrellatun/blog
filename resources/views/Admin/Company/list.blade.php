@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
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
                                           <i class="fas fa-warehouse mr-1"></i>เพิ่ม{{$titie}}
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                           <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel2"><i class="fas fa-warehouse mr-1"></i>เพิ่มบริษัท</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="FormAdd">
                                                         <div class="modal-body text-left">
                                                              <div class="row">
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>รหัสบริษัท</label>
                                                                             <input type="text" class="form-control" name="code" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ชื่อบริษัท</label>
                                                                             <input type="text" class="form-control" name="name" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เลขประจำตัวผู้เสียภาษี</label>
                                                                             <input type="text" class="form-control" name="tax_id" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เบอร์โทรศัพท์</label>
                                                                             <input type="text" class="form-control" name="tel" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>แฟ็ก</label>
                                                                             <input type="text" class="form-control" name="fax" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ที่อยู่</label>
                                                                             <textarea class="form-control" name="address" placeholder=""></textarea>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>จังหวัด</label>
                                                                             <select class="form-control" id="provinces_id" name="provinces_id">
                                                                                  <option value>กรุณาเลือก</option>
                                                                                  @foreach ($provinces as $key => $province)
                                                                                       <option value="{{$province->id}}">{{$province->name_th}}</option>
                                                                                  @endforeach
                                                                             </select>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>อำเภอ</label>
                                                                             <select class="form-control" id="amphures_id" name="amphures_id">
                                                                                  <option value>กรุณาเลือก</option>
                                                                             </select>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ตำบล</label>
                                                                             <select class="form-control" id="district" name="district">
                                                                             </select>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>รหัสไปรษณีย์</label>
                                                                             <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>อีเมล</label>
                                                                             <input type="text" class="form-control" name="email" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เรทค่าหยิบ</label>
                                                                             <input type="text" class="form-control" name="pick" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เรทค่าแพ็ค</label>
                                                                             <input type="text" class="form-control" name="pack" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เรทค่าส่ง</label>
                                                                             <input type="text" class="form-control" name="delivery" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <div class="switch d-inline m-r-10">
                                                                                  <input type="checkbox" checked class="switcher-input" name="use_flag" value="Y">
                                                                                  <label for="use_flag" class="cr"></label>
                                                                             </div>
                                                                             <label>ใช้งาน</label>
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
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                           <div class="modal-dialog modal-lg" role="document">
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
                                                               <label>ชื่อบริษัท</label>
                                                               <input type="text" class="form-control" id="name" name="name"  placeholder="">
                                                               <input type="text" class="form-control" id="id" name="id"  placeholder="">
                                                            </div>
                                                            <div class="form-group">
                                                               <label>เรทค่าหยิบ</label>
                                                               <input type="text" class="form-control" id="pick" name="pick"  placeholder="">
                                                            </div>
                                                            <div class="form-group">
                                                               <label>เรทค่าแพ็ค</label>
                                                               <input type="text" class="form-control" id="pack" name="pack"  placeholder="">
                                                            </div>
                                                            <div class="form-group">
                                                               <label>เรทค่าส่ง</label>
                                                               <input type="text" class="form-control" id="delivery" name="delivery"  placeholder="">
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
                                                <th class="border-top-0">ชื่อบริษัท</th>
                                                <th class="border-top-0">ค่าหยิบ</th>
                                                <th class="border-top-0">ค่าแพ็ค</th>
                                                <th class="border-top-0">ค่าขนส่ง</th>
                                                <th class="border-top-0">สถานะ</th>
                                                <th class="border-top-0">action</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($companies as $key => $company)
                                                  <tr>
                                                       <td>{{$company->name}}</td>
                                                       <td>{{$company->pick}}</td>
                                                       <td>{{$company->pack}}</td>
                                                       <td>{{$company->delivery}}</td>
                                                       <td>
                                                            @if ($company->use_flag == 'Y')
                                                                 <span class="badge bg-success text-dark">ใช้งาน</span>
                                                            @else
                                                                 <span class="badge bg-danger text-dark">ไม่ใช้งาน</span>
                                                            @endif
                                                       </td>
                                                       <td>
                                                            <div class="btn-group btn-group-sm">
                                                                 <button class="btn btn-warning btn-edit text-white" data-value="{{$company->id}}" data-toggle="modal" data-target="#ModalEdit">
                                                                      <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                 </button>
                                                                 <button class="btn btn-danger btn-delete text-white" data-value="{{$company->id}}">
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
                     },
                     beforeSend: function() {
                          $("#preloaders").css("display", "block");
                     },
                 }).done(function(rec){
                     btn.button("reset");
                     $("#preloaders").css("display", "none");
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

         $('body').on('change' , '#provinces_id', function(){
              if ($(this).val()){
                   $("#amphures_id").empty();
                   $("#district").empty();
                   $("#zipcode").val('');
                   $.ajax({
                        method : "POST",
                        data : {
                             "province_id" : $(this).val()
                        },
                        url : '{{ route('company.get_amphures')}}',
                        dataType : 'json',
                        beforeSend: function() {
                            $("#preloaders").css("display", "block");
                       },
                   }).done(function(rec){
                        $('#amphures_id').append('<option></option>');
                        $.each(rec, function (i, item) {
                             $('#amphures_id').attr("disabled", false);
                             $('#amphures_id').append($('<option>', {
                                  value: item.id,
                                  text : item.name_th
                             }));
                        });
                        $("#preloaders").css("display", "none");
                   }).fail(function(){
                        // swal("system.system_alert","system.system_error","error");
                        $("#preloaders").css("display", "none");
                   });
              }
         });

         $('body').on('change' , '#amphures_id', function(){
              if ($(this).val()){
                   $("#district").empty();
                   $("#zipcode").val('');
                   $.ajax({
                        method : "POST",
                        data : {
                             "amphures_id" : $(this).val()
                        },
                        url : '{{ route('company.get_districts')}}',
                        dataType : 'json',
                        beforeSend: function() {
                            $("#preloaders").css("display", "block");
                       },
                   }).done(function(rec){
                        $('#district').append('<option></option>');
                        $.each(rec, function (i, item) {
                             $('#district').attr("disabled", false);
                             $('#district').append($('<option>', {
                                  value: item.id,
                                  text : item.name_th
                             }));
                        });
                        $("#preloaders").css("display", "none");
                   }).fail(function(){
                        // swal("system.system_alert","system.system_error","error");
                        $("#preloaders").css("display", "none");
                   });
              }
         });

         $('body').on('change' , '#district', function(){
              if ($(this).val()){
                   $("#zipcode").val('');
                   $.ajax({
                        method : "POST",
                        data : {
                             "district_id" : $(this).val()
                        },
                        url : '{{ route('company.get_zipcode')}}',
                        dataType : 'json',
                        beforeSend: function() {
                            $("#preloaders").css("display", "block");
                       },
                   }).done(function(rec){
                        $('#zipcode').val(rec.zip_code);
                        $("#preloaders").css("display", "none");
                   }).fail(function(){
                        // swal("system.system_alert","system.system_error","error");
                        $("#preloaders").css("display", "none");
                   });
              }
         });
     </script>
@endsection
