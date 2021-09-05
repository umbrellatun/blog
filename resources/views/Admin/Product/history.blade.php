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
                                                <th class="text-center">Remark</th>
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
                                                       <td class="text-right">{{$productStock->remark}}</td>
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

     </script>
@endsection
