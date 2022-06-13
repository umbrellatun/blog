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
                                         <a href="{{ route('product.create') }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus"></i> เพิ่มสินค้า</a>
                                         <a href="#" class="btn waves-effect waves-light btn-danger m-0 btn-open-modal"><i class="fas fa-trash"></i> ลบสินค้า</a>
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
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">เพิ่มสินค้า</th>
                                                <th class="text-center">ลบสินค้า</th>
                                                <th class="text-center">จำนวนคงเหลือในโกดัง</th>
                                                <th class="text-left">Remark</th>
                                                <th class="text-center">ทำรายการโดย</th>
                                                <th class="text-center">เวลาที่ทำรายการ</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                             @foreach ($product->ProductStock as $key => $productStock)
                                                  <tr>
                                                       <td>{{$product->sku}}<br/>{{$product->name}}</td>
                                                       <td class="text-right">{{$productStock->plus}}</td>
                                                       <td class="text-right">{{$productStock->delete}}</td>
                                                       <td class="text-right">{{$productStock->stock}}</td>
                                                       <td class="text-left">{{$productStock->remark}}</td>
                                                       <td class="text-center">{{ $productStock->CreatedBy->name }} {{ $productStock->CreatedBy->lastname }}</td>
                                                       <td class="text-center">{{ $productStock->created_at }}</td>
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
     <div id="deleteProductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (function() {
                            'use strict';
                            window.addEventListener('load', function() {
                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                var forms = document.getElementsByClassName('needs-validation');
                                // Loop over them and prevent submission
                                var validation = Array.prototype.filter.call(forms, function(form) {
                                    form.addEventListener('submit', function(event) {
                                        if (form.checkValidity() === false) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                        form.classList.add('was-validated');
                                    }, false);
                                });
                            }, false);
                        })();
                    </script>
                    <form id="deleteProductForm" class="was-validated">
                         <div class="modal-header">
                              <h4>นำสินค้าออกจากโกดัง</h4>
                         </div>
                         <div class="modal-body">
                              <div class="row">
                                   <div class="col-md-12">
                                        <div class="form-group row">
                                             <label for="deleteProduct" class="col-sm-3 col-form-label">นำสินค้าออก</label>
                                             <div class="col-sm-9">
                                                  <input type="number" class="form-control" id="deleteProduct" name="deleteProduct" placeholder="จำนวนชิ้น" required>
                                             </div>
                                        </div>
                                        <div class="form-group row">
                                             <label for="inputTextArea" class="col-sm-3 col-form-label">หมายเหตุ</label>
                                             <div class="col-sm-9">
                                                  <textarea class="form-control" id="inputTextArea" name="inputTextArea" placeholder="หมายเหตุในการนำสินค้าออกจากโกดัง" required></textarea>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="modal-footer">
                              <button type="button" class="btn btn-danger btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                              <button type="button" class="btn  btn-primary btn-update-product">อัพเดทคลังสินค้า</button>
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
     <!-- notification Js -->
     <script src="{{asset('assets/js/plugins/bootstrap-notify.min.js')}}"></script>
     <script type="text/javascript">
     function notify(from, align, icon, type, animIn, animOut, title) {
          $.notify({
               icon: icon,
               title:  title,
               message: '',
               url: ''
          }, {
               element: 'body',
               type: type,
               allow_dismiss: true,
               placement: {
                    from: from,
                    align: align
               },
               offset: {
                    x: 30,
                    y: 30
               },
               spacing: 10,
               z_index: 999999,
               delay: 2500,
               timer: 1000,
               url_target: '_blank',
               mouse_over: false,
               animate: {
                    enter: animIn,
                    exit: animOut
               },
               icon_type: 'class',
               template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
               '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
               '<span data-notify="icon"></span> ' +
               '<span data-notify="title">{1}</span> ' +
               '<span data-notify="message">{2}</span>' +
               '<div class="progress" data-notify="progressbar">' +
               '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
               '</div>' +
               '<a href="{3}" target="{4}" data-notify="url"></a>' +
               '</div>'
          });
     }
     $(document).ready(function() {
          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });
     });

     $('body').on('click', '.btn-update-product', function (e) {
          e.preventDefault();
          swal({
               title: 'คุณต้องการนำสินค้าออกจากโกดังใช่หรือไม่',
               icon: "warning",
               buttons: true,
               dangerMode: true,
          })
          .then((result) => {
               if (result == true){
                    $.ajax({
                         method : "POST",
                         url : '{{ route('product.takeOut', ['id' => $product->id]) }}',
                         data : $("#deleteProductForm").serialize(),
                         dataType : 'json',
                         headers: {
                              'X-CSRF-TOKEN': "{{ csrf_token() }}"
                         },
                         beforeSend: function() {
                              $("#preloaders").css("display", "block");
                         },
                    }).done(function(rec){
                         $("#preloaders").css("display", "none");
                         if (rec.status == 1) {
                              notify("top", "right", "feather icon-layers", "success", "", "", rec.content);
                              $("#deleteProductModal").modal('hide');
                         } else {
                              notify("top", "right", "feather icon-layers", "danger", "", "", rec.content);
                         }
                    }).fail(function(){
                         $("#preloaders").css("display", "none");
                         notify("top", "right", "feather icon-layers", "danger", "", "", "Error");
                    });
               }
          });
     });

     $('body').on('click','.btn-open-modal',function(e){
          e.preventDefault();
          $("#deleteProductModal").modal('show');
     });



     </script>
@endsection
