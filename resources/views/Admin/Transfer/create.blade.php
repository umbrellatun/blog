@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<!-- fileupload-custom css -->
<link rel="stylesheet" href="{{asset('assets/css/plugins/dropzone.min.css')}}">
@section('css_bottom')
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
                                     <li class="breadcrumb-item"><a href="{{route('order.manage', ['id' => $order->id])}}">จัดการคำสั่งซื้อ</a></li>
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
                                <h5>File Upload</h5>
                            </div>
                            <div class="card-body">
                                <form id="FormAdd">
                                     {{-- action="{{asset('assets/json/file-upload.php')}}" --}}
                                     {{-- class="dropzone" --}}
                                    <div class="fallback">
                                        <input name="file" type="file"  />
                                    </div>
                                </form>
                                <div class="text-center m-t-20">
                                    <button id="btn-upload" class="btn btn-primary">Upload Now</button>
                                </div>
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
     <!-- file-upload Js -->
     <script src="{{asset('assets/js/plugins/dropzone-amd-module.min.js')}}"></script>
     <script type="text/javascript">
         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
            });
         });

         $('body').on('click','#btn-upload',function(e){
              e.preventDefault();
              var form = $('#FormAdd')[0];
              var formData = new FormData(form);
              $.ajax({
                   method : "POST",
                   url : '{{ route('transfer.store', ['order_id' => $order->id]) }}',
                   dataType : 'json',
                   data : formData,
                   processData: false,
                   contentType: false,
              }).done(function( rec ) {

              }).fail(function(){

              });
         });
     </script>
@endsection
