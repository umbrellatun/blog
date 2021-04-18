@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
    <div class="pcoded-inner-content">
       <div class="main-body">
           <div class="page-wrapper">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                     <div class="page-block">
                          <div class="row align-items-center">
                               <div class="col-md-12">
                                    <div class="page-header-title">
                                         <h5 class="m-b-10"><i class="fas fa-file-invoice mr-2"></i>{{$titie}}</h5>
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
                <div class="row">
                    <!-- [ Invoice ] start -->
                    <div class="container" id="printTable">
                        <div>
                            <div class="card">
                                <div class="row invoice-contact">
                                    <div class="col-md-8">
                                        <div class="invoice-box row">
                                            <div class="col-sm-12">
                                                <table class="table table-responsive invoice-table table-borderless p-l-20">
                                                    <tbody>
                                                        <tr>
                                                            <td><a href="index.html" class="b-brand">
                                                                    <img class="img-fluid" src="{{asset('assets/images/logo-dark.png')}}" alt="Gradient able Logo">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$order->Company->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                 {{$order->Company->address}}
                                                                 {{$order->Company->Amphure->name_th}}
                                                                 {{$order->Company->Province->name_th}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a class="text-secondary" href="mailto:demo@gmail.com" target="_top">{{$order->Company->email}}</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tel:{{$order->Company->tel}}, Fax:{{$order->Company->fax}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <div class="card-body">
                                    <div class="row invoive-info">
                                        <div class="col-md-4 col-xs-12 invoice-client-info">
                                            <h6>Client Information :</h6>
                                            <h6 class="m-0">{{$order->customer_name}}</h6>
                                            <p class="m-0 m-t-10">{{$order->customer_address}}
                                            {{$order->customer_city}}
                                            {{$order->LaosDistrict->name}}</p>
                                            <p class="m-0">{{$order->customer_phone_number}}</p>
                                            {{-- <p><a class="text-secondary" href="mailto:demo@gmail.com" target="_top">demo@gmail.com</a></p> --}}
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <h6>Order Information :</h6>
                                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th>Date :</th>
                                                        <td>{{ date_format($order->created_at, "d M Y")}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status :</th>
                                                        <td>
                                                            <span class="label label-warning">
                                                                 @if ($order->status == 'W')
                                                                      <span class="text-primary"><u>รอแนบหลักฐานการโอน</u></span>
                                                                 @elseif($order->status == 'WA')
                                                                      <span class="text-primary"><u>ตรวจสอบหลักฐานการโอนแล้ว รอแพ็ค</u></span>
                                                                 @elseif($order->status == 'P')
                                                                      <span class="text-primary"><u>แพ็คสินค้าแล้ว รอเลขแทรคกิ้ง</u></span>
                                                                 @elseif($order->status == 'T')
                                                                      <span class="text-primary"><u>จัดส่งแล้วรอปรับสถานะ</u></span>
                                                                 @elseif($order->status == 'S')
                                                                      <span class="text-success"><u>เสร็จสมบูรณ์</u></span>
                                                                 @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Order no :</th>
                                                        <td>
                                                            {{$order->order_no}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <h6 class="m-b-20">Invoice Number <span>#{{$order->order_no}}</span></h6>
                                            <h6 class="text-uppercase text-primary">Total Price :
                                                <span>{{$total_price}}</span>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table invoice-detail-table">
                                                    <thead>
                                                        <tr class="thead-default">
                                                            <th>Description</th>
                                                            <th>Quantity</th>
                                                            <th>Amount</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         @foreach ($order->OrderProduct as $key => $order_product)
                                                              <tr>
                                                                  <td>
                                                                      <h6>{{$order_product->Product->name}}</h6>
                                                                      <p class="m-0">{{$order_product->Product->sku}}</p>
                                                                  </td>
                                                                  <td>1</td>
                                                                  <td>฿{{$order_product->price_bath}}</td>
                                                                  <td>฿{{$order_product->price_bath}}</td>
                                                              </tr>
                                                         @endforeach
                                                         @foreach ($order->OrderBoxs as $key => $order_box)
                                                              <tr>
                                                                  <td>
                                                                      <h6>{{$order_box->Box->size}}<br/></h6>
                                                                      <p class="m-0">{{$order_box->Box->description}}</p>
                                                                  </td>
                                                                  <td>1</td>
                                                                  <td>฿{{$order_box->price_bath}}</td>
                                                                  <td>฿{{$order_box->price_bath}}</td>
                                                              </tr>
                                                         @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-responsive invoice-table invoice-total">
                                                <tbody>
                                                    <tr>
                                                        <th>ราคาสินค้า :</th>
                                                        <td>{{$total_price}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ค่าขนส่ง :</th>
                                                        <td>{{$order->shipping_cost}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ส่วนลด :</th>
                                                        <td>{{ isset($order->discount) ? $order->discount : 0}}</td>
                                                    </tr>
                                                    <tr class="text-info">
                                                        <td>
                                                            <hr />
                                                            <h5 class="text-primary m-r-10">Total :</h5>
                                                        </td>
                                                        <td>
                                                            <hr />
                                                            <h5 class="text-primary">{{ number_format($total_price + $order->shipping_cost - $order->discount, 2)}}</h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Terms and Condition :</h6>
                                            <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12 invoice-btn-group text-center">
                                    <button type="button" class="btn waves-effect waves-light btn-primary btn-print-invoice m-b-10">Print</button>
                                    <button type="button" class="btn waves-effect waves-light btn-secondary m-b-10 ">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Invoice ] end -->
                </div>
           </div>
       </div>
   </div>
@endsection
@section('modal')

@endsection
@section('js_bottom')
     <script type="text/javascript">
         $(document).ready(function() {
            $("#pcoded").pcodedmenu({
                 themelayout: 'horizontal',
                 MenuTrigger: 'hover',
                 SubMenuTrigger: 'hover',
            });
         });
         function printData() {
             var divToPrint = document.getElementById("printTable");
             newWin = window.open("");
             newWin.document.write(divToPrint.outerHTML);
             newWin.print();
             newWin.close();
         }
         $('.btn-print-invoice').on('click', function() {
             printData();
         })
     </script>
@endsection
