@inject('orderInject', 'App\Http\Controllers\Admin\OrderController')
@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
@section('css_bottom')
@endsection
@section('body')
    <div class="pcoded-inner-content">
         <div class="page-header">
              <div class="page-block">
                   <div class="row align-items-center">
                        <div class="col-md-12">
                             <div class="page-header-title">
                                  <h5 class="m-b-10">{{$titie}}</h5>
                             </div>
                             <ul class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                  <li class="breadcrumb-item"><a href="#!">ขนส่ง</a></li>
                             </ul>
                        </div>
                   </div>
              </div>
         </div>
       <div class="main-body">
           <div class="page-wrapper">

               <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-none">
                            <div class="card-body shadow border-0">
                                <div class="dt-responsive table-responsive">
                                    <table  class="table table-striped table-bordered nowrap">
                                        <thead>
                                           <tr>
                                                <th class="border-top-0">ชื่อขนส่ง</th>
                                                <th class="border-top-0 text-right">ราคา (THB)</th>
                                                <th class="border-top-0 text-right">ชิ้น</th>
                                                <th class="border-top-0 text-center">สถานะ</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($shippings->ShippingOrder as $key => $ShippingOrder)
                                                  <tr>
                                                       <td>{{$ShippingOrder->Order->order_no}}</td>
                                                       <td></td>
                                                       <td></td>
                                                       <td class="text-center">
                                                            <span class="badge badge-light-warning">{{$orderInject->GetOrderStatus($ShippingOrder->status)}}</span>
                                                       </td>
                                                  </tr>
                                                  @foreach ($ShippingOrder->Order->OrderProduct as $key => $OrderProduct)
                                                       <tr>
                                                            <td><span class="ml-5">{{($OrderProduct->Product->name)}}</span></td>
                                                            <td class="text-right">{{($OrderProduct->Product->price_bath)}}</td>
                                                            <td class="text-right">1</td>
                                                            <td></td>
                                                       </tr>
                                                  @endforeach
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
