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
                                  <li class="breadcrumb-item"><a href="#!">{{$titie}}</a></li>
                             </ul>
                        </div>
                   </div>
              </div>
         </div>

         <div class="row">
              <div class="col-sm-12">
                 <div class="card tabs-card">
                     <div class="card-body">
                         <!-- Nav tabs -->
                         <ul class="nav nav-pills nav-fill mb-3" role="tablist">
                              @foreach ($currencies as $key => $currency)
                                   <li class="nav-item">
                                       <a class="nav-link text-light {{$key == 0 ? 'active' : ''}}" data-toggle="tab" href="#currency{{$currency->id}}" role="tab">
                                            <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 25px;" class="mr-2">{{$currency->name}}</a>
                                       <div class="slide bg-c-green"></div>
                                   </li>
                              @endforeach
                             {{-- <li class="nav-item">
                                 <a class="nav-link active text-light" data-toggle="tab" href="#home3" role="tab"><i class="fa fa-home m-r-10"></i>Home</a>
                                 <div class="slide bg-c-blue"></div>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link text-light" data-toggle="tab" href="#profile3" role="tab"><i class="fa fa-key m-r-10"></i>Security</a>
                                 <div class="slide bg-c-green"></div>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link text-light" data-toggle="tab" href="#messages3" role="tab"><i class="fa fa-play-circle m-r-10"></i>Entertainment</a>
                                 <div class="slide bg-c-red"></div>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link text-light" data-toggle="tab" href="#settings3" role="tab"><i class="fa fa-database m-r-10"></i>Big Data</a>
                                 <div class="slide bg-c-yellow"></div>
                             </li> --}}
                         </ul>
                         <!-- Tab panes -->
                         <div class="tab-content">
                              @foreach ($currencies as $key => $currency)
                                   <div class="tab-pane {{$key == 0 ? 'active' : ''}}" id="currency{{$currency->id}}" role="tabpanel">
                                        <div class="row">
                                             <div class="col-lg-12">
                                                  <div class="card user-profile-list">
                                                       <div class="card-body">
                                                            <div class="dt-responsive table-responsive">
                                                                 <table id="user-list-table" class="table nowrap">
                                                                      <thead>
                                                                           <tr>
                                                                              <th class="text-left">Order No.</th>
                                                                              <th class="text-left">??????????????????????????????</th>
                                                                              <th class="text-center">????????????</th>
                                                                              <th class="text-center">???????????????</th>
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                           @foreach ($orders as $key => $order)
                                                                                @if ($order->currency_id == $currency->id)
                                                                                     <tr>
                                                                                          <td class="text-left">{{$order->order_no}}</td>
                                                                                          <td class="text-left">
                                                                                               {{$order->customer_name}}
                                                                                               <br/> {{$order->Customer->address}} {{$order->Customer->city}}
                                                                                               <br/> {{$order->Customer->LaosDistrict->name}} {{$order->Customer->phone_number}}
                                                                                          </td>
                                                                                          <td class="text-center">{!! $orderInject->getOrderCOD($order->id) !!}</td>
                                                                                          <td class="text-center"><span class="badge {{$orderInject->GetBgOrderStatus($order->status)}}"> {{$orderInject->GetOrderStatus($order->status)}} </span></td>
                                                                                     </tr>
                                                                                @endif
                                                                           @endforeach
                                                                      </tbody>
                                                                 </table>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              @endforeach
                         </div>
                     </div>
                 </div>
             </div>
        </div>
       {{-- <div class="main-body">
           <div class="page-wrapper">
               <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-none">
                            <div class="card-body shadow border-0">
                                <div class="dt-responsive table-responsive">
                                    <table  class="table table-striped table-bordered nowrap">
                                        <thead>
                                           <tr>
                                                <th class="border-top-0">Order NO.</th>
                                                <th class="border-top-0 text-right">???????????? (THB)</th>
                                                <th class="border-top-0 text-center">???????????????</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>

           </div>
       </div> --}}
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
                     required: "???????????????????????????",
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
                     required: "???????????????????????????",
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
                     title: '???????????????????????????????????????????????????????????????????',
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
