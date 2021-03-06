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
                                                                             <input type="text" class="form-control" name="code" value="" placeholder="">
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
                                                                             <input type="text" class="form-control number-only" name="tax_id" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เบอร์โทรศัพท์</label>
                                                                             <input type="text" class="form-control number-only" name="tel" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>แฟ็ก</label>
                                                                             <input type="text" class="form-control number-only" name="fax" placeholder="">
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
                                                                             <select class="form-control provinces_id" name="provinces_id">
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
                                                                             <select class="form-control amphures_id" name="amphures_id">
                                                                                  <option value>กรุณาเลือก</option>
                                                                             </select>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ตำบล</label>
                                                                             <select class="form-control district" name="district">
                                                                             </select>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>รหัสไปรษณีย์</label>
                                                                             <input type="text" class="form-control zipcode" name="zipcode" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>อีเมล</label>
                                                                             <input type="text" class="form-control" name="email" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   {{-- <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เรทค่าหยิบ</label>
                                                                             <input type="text" class="form-control number-only" name="pick" placeholder="">
                                                                        </div>
                                                                   </div> --}}
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เรทค่าหยิบ/แพ็ค</label>
                                                                             <input type="text" class="form-control number-only" name="pack" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ค่า COD (%)</label>
                                                                             <input type="text" class="form-control number-only" name="delivery" placeholder="">
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
                                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-warehouse mr-1"></i>แก้ไข{{$titie}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="FormEdit">
                                                         <div class="modal-body text-left">
                                                              <div class="row">
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>รหัสบริษัท</label>
                                                                             <input type="text" class="form-control" id="code" name="code" placeholder="" value="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ชื่อบริษัท</label>
                                                                             <input type="text" class="form-control" id="name" name="name" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เลขประจำตัวผู้เสียภาษี</label>
                                                                             <input type="text" class="form-control" id="tax_id" name="tax_id" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เบอร์โทรศัพท์</label>
                                                                             <input type="text" class="form-control" id="tel" name="tel" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>แฟ็ก</label>
                                                                             <input type="text" class="form-control" id="fax" name="fax" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ที่อยู่</label>
                                                                             <textarea class="form-control" id="address" name="address" placeholder=""></textarea>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>จังหวัด</label>
                                                                             <select class="form-control provinces_id" id="provinces_id" name="provinces_id">
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
                                                                             <select class="form-control amphures_id" id="amphures_id" name="amphures_id">
                                                                                 <option value>กรุณาเลือก</option>
                                                                             </select>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ตำบล</label>
                                                                             <select class="form-control district" id="district" name="district">
                                                                             </select>
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>รหัสไปรษณีย์</label>
                                                                             <input type="text" class="form-control zipcode" id="zipcode" name="zipcode" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>อีเมล</label>
                                                                             <input type="text" class="form-control" id="email" name="email" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   {{-- <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เรทค่าหยิบ</label>
                                                                             <input type="text" class="form-control" id="pick" name="pick" placeholder="">
                                                                        </div>
                                                                   </div> --}}
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>เรทค่าหยิบ/แพ็ค</label>
                                                                             <input type="text" class="form-control" id="pack" name="pack" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <label>ค่า COD (%)</label>
                                                                             <input type="text" class="form-control" id="delivery" name="delivery" placeholder="">
                                                                        </div>
                                                                   </div>
                                                                   <div class="col-6">
                                                                        <div class="form-group">
                                                                             <div class="switch d-inline m-r-10">
                                                                                 <input type="checkbox" checked class="switcher-input" id="use_flag" name="use_flag" value="Y">
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
                                                      {{-- <th class="text-right border-top-0">ค่าหยิบ (บาท) </th> --}}
                                                      <th class="text-right border-top-0">ค่าหยิบ/แพ็ค (บาท) </th>
                                                      <th class="text-right border-top-0">ค่า COD (%)</th>
                                                      <th class="border-top-0">สถานะ</th>
                                                      <th class="border-top-0">action</th>
                                                 </tr>
                                            </thead>
                                            <tbody>
                                                 @foreach ($companies as $key => $company)
                                                      <tr>
                                                           <td>{{$company->name}}</td>
                                                           {{-- <td class="text-right">{{ number_format($company->pick,2)}}</td> --}}
                                                           <td class="text-right">{{ number_format($company->pack,2)}}</td>
                                                           <td class="text-right">{{ number_format($company->delivery,2)}}</td>
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
                    code:{
                        required: true,
                    },
                    name:{
                        required: true,
                    },
                    tax_id:{
                        required: true,
                    },
                    tel:{
                        required: true,
                    },
                    address:{
                        required: true,
                    },
                    provinces_id:{
                        required: true,
                    },
                    amphures_id:{
                        required: true,
                    },
                    district:{
                        required: true,
                    },
                    zipcode:{
                        required: true,
                    },
                    email:{
                        required: true,
                    },
                    pick:{
                        required: true,
                    },
                    pack:{
                        required: true,
                    },
                    delivery:{
                        required: true,
                    },
             },
             messages: {
                 code:{
                    required: "กรุณาระบุ",
                 },
                 name:{
                    required: "กรุณาระบุ",
                 },
                 tax_id:{
                    required: "กรุณาระบุ",
                 },
                 tel:{
                    required: "กรุณาระบุ",
                 },
                 address:{
                    required: "กรุณาระบุ",
                 },
                 provinces_id:{
                    required: "กรุณาระบุ",
                 },
                 amphures_id:{
                    required: "กรุณาระบุ",
                 },
                 district:{
                    required: "กรุณาระบุ",
                 },
                 zipcode:{
                    required: "กรุณาระบุ",
                 },
                 email:{
                    required: "กรุณาระบุ",
                 },
                 pick:{
                    required: "กรุณาระบุ",
                 },
                 pack:{
                    required: "กรุณาระบุ",
                 },
                 delivery:{
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
                 btn.button("loading");
                 $.ajax({
                     method : "POST",
                     url : '{{ route('company.store') }}',
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
                               window.location.href = "{{ route('company') }}";
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
                  code:{
                     required: true,
                  },
                  name:{
                     required: true,
                  },
                  tax_id:{
                     required: true,
                  },
                  tel:{
                     required: true,
                  },
                  address:{
                     required: true,
                  },
                  provinces_id:{
                     required: true,
                  },
                  amphures_id:{
                     required: true,
                  },
                  district:{
                     required: true,
                  },
                  zipcode:{
                     required: true,
                  },
                  email:{
                     required: true,
                  },
                  pick:{
                     required: true,
                  },
                  pack:{
                     required: true,
                  },
                  delivery:{
                     required: true,
                  },
             },
             messages: {
                  code:{
                     required: "กรุณาระบุ",
                  },
                  name:{
                     required: "กรุณาระบุ",
                  },
                  tax_id:{
                     required: "กรุณาระบุ",
                  },
                  tel:{
                     required: "กรุณาระบุ",
                  },
                  address:{
                     required: "กรุณาระบุ",
                  },
                  provinces_id:{
                     required: "กรุณาระบุ",
                  },
                  amphures_id:{
                     required: "กรุณาระบุ",
                  },
                  district:{
                     required: "กรุณาระบุ",
                  },
                  zipcode:{
                     required: "กรุณาระบุ",
                  },
                  email:{
                     required: "กรุณาระบุ",
                  },
                  pick:{
                     required: "กรุณาระบุ",
                  },
                  pack:{
                     required: "กรุณาระบุ",
                  },
                  delivery:{
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
                 var btn = $("#FormEdit").find('[type="submit"]');
                 btn.button("loading");
                 $.ajax({
                     method : "POST",
                     url : '{{ route('company.update') }}',
                     dataType : 'json',
                     data : $("#FormEdit").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 }).done(function(rec){
                      btn.button("reset");
                      if (rec.status == 1) {
                           swal("", rec.content, "success").then(function(){
                                window.location.href = "{{ route('company') }}";
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
              $(".amphures_id").empty();
              var data = $(this).data('value');
              $.ajax({
                   method : "get",
                   url : url_gb + '/admin/company/' + data,
                   dataType : 'json',
                   beforeSend: function() {
                        $("#preloaders").css("display", "block");
                   },
              }).done(function(rec){
                    $("#code").val(rec.company.code);
                    $("#name").val(rec.company.name);
                    $("#tax_id").val(rec.company.tax_id);
                    $("#tel").val(rec.company.tel);
                    $("#fax").val(rec.company.fax);
                    $("#address").val(rec.company.address);
                    $("#provinces_id").val(rec.company.provinces_id);
                    $("#amphures_id").val(rec.company.amphures_id);
                    $("#district").val(rec.company.district);
                    $("#zipcode").val(rec.company.zipcode);
                    $("#email").val(rec.company.email);
                    $("#pick").val(rec.company.pick);
                    $("#pack").val(rec.company.pack);
                    $("#delivery").val(rec.company.delivery);
                    if (rec.company.use_flag == 'Y') {
                         $("#use_flag").prop("checked", true);
                    } else {
                         $("#use_flag").prop("checked", false);
                    }

                    $.each(rec.amphures, function( index, amphure ) {
                         $('.amphures_id').append($('<option>', {
                              value: amphure.id,
                              text : amphure.name_th
                         }));
                    });

                    $.each(rec.districts, function( index, district ) {
                         $('.district').append($('<option>', {
                              value: district.id,
                              text : district.name_th
                         }));
                    });
                   $("#preloaders").css("display", "none");
              }).fail(function(){
                   $("#preloaders").css("display", "none");
                   // swal("", rec.content, "error");
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
                                url : '{{ route('company.destroy') }}',
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
                                         window.location.href = "{{ route('company') }}";
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

         $('body').on('change' , '.provinces_id', function(){
              if ($(this).val()){
                   $(".amphures_id").empty();
                   $(".district").empty();
                   $(".zipcode").val('');
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
                        $('.amphures_id').append('<option></option>');
                        $.each(rec, function (i, item) {
                             $('.amphures_id').attr("disabled", false);
                             $('.amphures_id').append($('<option>', {
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

         $('body').on('change' , '.amphures_id', function(){
              if ($(this).val()){
                   $(".district").empty();
                   $(".zipcode").val('');
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
                        $('.district').append('<option></option>');
                        $.each(rec, function (i, item) {
                             $('.district').attr("disabled", false);
                             $('.district').append($('<option>', {
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

         $('body').on('change' , '.district', function(){
              if ($(this).val()){
                   $(".zipcode").val('');
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
                        $('.zipcode').val(rec.zip_code);
                        $("#preloaders").css("display", "none");
                   }).fail(function(){
                        // swal("system.system_alert","system.system_error","error");
                        $("#preloaders").css("display", "none");
                   });
              }
         });
     </script>
@endsection
