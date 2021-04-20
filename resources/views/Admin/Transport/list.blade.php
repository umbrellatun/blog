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
                                {{-- <div class="col-md-4 text-right">
                                    <div class="btn-cust">
                                         <a href="{{ route('order.create') }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus"></i> เพิ่มคำสั่งซื้อ</a>
                                    </div>
                                </div> --}}
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
                                             @foreach ($orders as $order)
                                                  @php
                                                       $sum_product_bath = 0;
                                                       $sum_product_lak = 0;
                                                       $sum_box_bath = 0;
                                                       $sum_box_lak = 0;
                                                  @endphp
                                                  @foreach ($order->OrderProduct as $order_product)
                                                       @php
                                                            $sum_product_bath += $order_product->price_bath;
                                                            $sum_product_lak += $order_product->price_lak;
                                                       @endphp
                                                  @endforeach
                                                  @foreach ($order->OrderBoxs as $order_box)
                                                       @php
                                                            $sum_box_bath += $order_box->price_bath;
                                                            $sum_box_lak += $order_box->price_lak;
                                                       @endphp
                                                  @endforeach
                                                  <tr>
                                                       <td>{{$order->order_no}}</td>
                                                       <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                       <td>{{$order->Customer->name}}</td>
                                                       <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                       <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                       <td>{{$order->Shipping->name}}</td>
                                                       <td>
                                                            @if ($order->status == 'W')
                                                                 @php
                                                                 $txt_status = 'รอแนบหลักฐานการโอน';
                                                                 $class = 'text-warning';
                                                                 @endphp
                                                            @elseif ($order->status == 'WA')
                                                                 @php
                                                                 $txt_status = 'ตรวจสอบหลักฐานการโอนแล้ว รอแพ็ค';
                                                                 $class = 'text-warning';
                                                                 @endphp
                                                            @elseif ($order->status == 'P')
                                                                 @php
                                                                 $txt_status = 'แพ็คสินค้าแล้ว อยู่ระหว่างจัดส่ง';
                                                                 $class = 'text-primary';
                                                                 @endphp
                                                            @elseif ($order->status == 'T')
                                                                 @php
                                                                 $txt_status = 'จัดส่งแล้ว รอปรับสถานะ';
                                                                 $class = 'text-primary';
                                                                 @endphp
                                                            @elseif ($order->status == 'S')
                                                                 @php
                                                                 $txt_status = 'เสร็จสมบูรณ์';
                                                                 $class = 'text-success';
                                                                 @endphp
                                                            @endif
                                                            <span class="{{$class}}"> {{$txt_status}} </span>
                                                       </td>
                                                       <td>
                                                            <div class="btn-group btn-group-sm">
                                                                 {{-- <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                      <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                 </a> --}}
                                                                 <a class="btn btn-primary btn-edit text-white" href="{{ route('order.manage', ['id' => $order->id]) }}">
                                                                      <i class="fas fa-bars"></i>
                                                                 </a>
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
