@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
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
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="d-inline-block mb-0">{{$titie}}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="btn-cust">
                                         <a href="{{ route('transfer.create', ['order_id' => $order->id]) }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus"></i> แนบหลักฐานการโอน</a>
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
                                                <th class="border-top-0">No.</th>
                                                <th class="border-top-0">ชื่อไฟล์</th>
                                                <th class="border-top-0">จำนวนเงิน</th>
                                                <th class="border-top-0">วันที่โอน</th>
                                                <th class="border-top-0">เวลาโอน</th>
                                                <th class="border-top-0">หมายเหตุ</th>
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

     </script>
@endsection
