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
                                         <a href="{{ route('order.create') }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus"></i> เพิ่มสินค้า</a>
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
                                                <th class="border-top-0">Order no.</th>
                                                <th class="border-top-0">วันที่สร้าง</th>
                                                <th class="border-top-0">ลูกค้า</th>
                                                <th class="border-top-0">จำนวนเงิน(บาท)</th>
                                                <th class="border-top-0">จำนวนเงิน(กีบ)</th>
                                                <th class="border-top-0">วิธีการจัดส่ง</th>
                                                <th class="border-top-0">สถานะ</th>
                                                <th class="border-top-0">action</th>
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

     <script type="text/javascript">
         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
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
                             url : url_gb + '/admin/order/' + $(this).data("value"),
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
