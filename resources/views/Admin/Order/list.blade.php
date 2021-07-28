@inject('orderInject', 'App\Http\Controllers\Admin\OrderController')
@inject('packInject', 'App\Http\Controllers\Admin\PackController')
@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<!-- data tables css -->
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
                                         <a href="{{ route('order.create') }}" class="btn waves-effect waves-light btn-primary m-0"><i class="fas fa-plus mr-2"></i>สร้างคำสั่งซื้อ</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-none user-profile-list">
                             <nav class="navbar m-b-30 p-10">
                               <ul class="nav">
                                    <li class="nav-item mr-2">
                                         <a href="#" class="btn waves-effect waves-light btn-info m-0 create-document-btn"><i class="fas fa-print mr-2"></i>สร้างเอกสาร</a>
                                    </li>
                               </ul>
                            </nav>
                            <div class="card-body shadow border-0">
                                 <ul class="nav nav-pills nav-fill mb-3" role="tablist">
                                      <li class="nav-item">
                                           <a class="nav-link active font-weight-bold text-white" data-toggle="tab" href="#status_all" role="tab"></i>ทั้งหมด</a>
                                           <div class="slide bg-c-blue"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_w" role="tab">รอหลักฐานการชำระเงิน</a>
                                           <div class="slide bg-c-green"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_wa" role="tab">รอตรวจสอบหลักฐานการชำระเงิน</a>
                                           <div class="slide bg-c-green"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_p" role="tab">รอแพ็คสินค้า</a>
                                           <div class="slide bg-c-red"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_fp" role="tab">สแกนครบแล้ว</a>
                                           <div class="slide bg-c-red"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_wt" role="tab">รอขนส่งเข้ามารับสินค้า</a>
                                           <div class="slide bg-c-yellow"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_t" role="tab">อยู่ระหว่างจัดส่ง</a>
                                           <div class="slide bg-c-yellow"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_s" role="tab">สำเร็จ</a>
                                           <div class="slide bg-c-yellow"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold text-white" data-toggle="tab" href="#status_c" role="tab">ยกเลิก</a>
                                           <div class="slide bg-c-yellow"></div>
                                      </li>
                                 </ul>
                                 <div class="tab-content mt-5">
                                      <div class="tab-pane active" id="status_all" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>#</th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="btn-group btn-group-sm">
                                                                              <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
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
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_w" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>#</th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'W') as $order)
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span class="badge badge-light-warning"> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="overlay-edit text-center" style="opacity: 1; background: none;">
                                                                              <a class="btn btn-warning btn-edit text-white" data-toggle="tooltip" title="แก้ไขรายการสั่งซื้อ" href="{{ route('order.edit', ['id' => $order->id]) }}" target="_blank">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
                                                                              <a class="btn btn-info btn-edit text-white" data-toggle="tooltip" title="แนบหลักฐานการโอน" href="{{ route('transfer.create', ['order_id' => $order->id]) }}" target="_blank">
                                                                                   <i class="fas fa-paperclip"></i>
                                                                              </a>
                                                                              {{-- <button type="button" class="btn btn-icon btn-success"><i class="feather icon-check-circle"></i></button> --}}
                                                                              {{-- <button type="button" class="btn btn-icon btn-danger"><i class="feather icon-trash-2"></i></button> --}}
                                                                         </div>
                                                                         <div class="btn-group btn-group">


                                                                         </div>
                                                                    </td>
                                                               </tr>
                                                          @endforeach
                                                     </tbody>
                                                </table>
                                           </div>
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_wa" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>#</th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'WA') as $order)
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span class="badge badge-light-warning"> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="overlay-edit text-center" style="opacity: 1; background: none;">
                                                                              <a class="btn btn-info btn-edit text-white" data-toggle="tooltip" title="ตรวจสอบหลักฐานการโอน" href="{{ route('transfer', ['order_id' => $order->id]) }}" target="_blank">
                                                                                   <i class="feather icon-check-circle"></i> <i class="fas fa-paperclip"></i>
                                                                              </a>
                                                                         </div>
                                                                    </td>
                                                               </tr>
                                                          @endforeach
                                                     </tbody>
                                                </table>
                                           </div>
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_p" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>
                                                                    <input type="checkbox" class="order_chk_all_p">
                                                               </th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'P') as $order)
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
                                                                    <td class="text-center">
                                                                         <input type="checkbox" class="order_chk_p" value="{{$order->id}}">
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span class="badge badge-light-warning badge-pill f-12 mr-2">{{$orderInject->GetOrderStatus($order->status)}}</span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="overlay-edit text-center" style="opacity: 1; background: none;">
                                                                              <a class="btn btn-info text-white" data-toggle="tooltip" title="แพ็คสินค้า" href="{{ route('pack.create', ['order_id' => $order->id]) }}" target="_blank">
                                                                                   <i class="fas fa-box-open"></i>
                                                                              </a>
                                                                              <a class="btn btn-warning text-white" data-toggle="tooltip" title="ใบแพ็คสินค้า" href="{{ route('order.coverSheet', ['id' => $order->id]) }}" target="_blank">
                                                                                   <i class="fas fa-print"></i>
                                                                              </a>
                                                                         </div>
                                                                    </td>
                                                               </tr>
                                                          @endforeach
                                                     </tbody>
                                                </table>
                                           </div>
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_fp" role="tabpanel">
                                           {{-- <nav class="navbar m-b-30 p-10">
                                              <ul class="nav">
                                                  <li class="nav-item mr-2">
                                                       <a href="#" class="btn waves-effect waves-light btn-info m-0"><i class="fas fa-print mr-2"></i>สร้างเอกสาร</a>
                                                  </li>
                                                  <li class="nav-item mr-2">
                                                       <a href="#" class="btn waves-effect waves-light btn-info m-0 adjust_status_order"><i class="fas fa-cogs mr-2"></i>จัดส่งแบบชุด</a>
                                                  </li>
                                              </ul>
                                          </nav> --}}
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th><input type="checkbox"></th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'FP') as $order)
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk_p form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span class="badge badge-light-success badge-pill f-12 mr-2">{{$orderInject->GetOrderStatus($order->status)}}</span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="overlay-edit text-center" style="opacity: 1; background: none;">
                                                                              <a class="btn btn-info text-white" data-toggle="tooltip" title="แพ็คสินค้า" href="{{ route('pack.create', ['order_id' => $order->id]) }}" target="_blank">
                                                                                   <i class="fas fa-box-open"></i>
                                                                              </a>
                                                                              <a class="btn btn-warning text-white" data-toggle="tooltip" title="ใบแพ็คสินค้า" href="{{ route('order.coverSheet', ['id' => $order->id]) }}" target="_blank">
                                                                                   <i class="fas fa-print"></i>
                                                                              </a>
                                                                         </div>
                                                                    </td>
                                                               </tr>
                                                          @endforeach
                                                     </tbody>
                                                </table>
                                           </div>
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_wt" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>#</th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'WT') as $order)
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="btn-group btn-group-sm">
                                                                              <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
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
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_t" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>#</th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'T') as $order)
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="btn-group btn-group-sm">
                                                                              <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
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
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_s" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>#</th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'S') as $order)
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="btn-group btn-group-sm">
                                                                              <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
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
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
                                      <div class="tab-pane" id="status_c" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th>#</th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($orders->where('status', 'C') as $order)
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
                                                                    <td>
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk form-check-input" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td>{{$order->order_no}}</td>
                                                                    <td>{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td>{{$order->Customer->name}}</td>
                                                                    <td>{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td>{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td>{{ $order->Shipping->name }}</td>
                                                                    <td>
                                                                         <span> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="btn-group btn-group-sm">
                                                                              <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
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
                                           <div class="text-center">
                                                <button class="btn btn-outline-primary btn-round btn-sm">Load More</button>
                                           </div>
                                      </div>
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
     <div class="modal fade create-document-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title h4" id="myLargeModalLabel">สร้างเอกสารการจัดส่งพัสดุ</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <div class="row">
                              <div class="col-12 mb-5">
                                   <h6 class="mt-4">กรุณาเลือกประเภทที่ต้องการพิมพ์เอกสารการจัดส่งพัสดุ</h6>
                                   <hr class="bg-primary">
                                   <div class="form-group">
                                        <div class="checkbox checkbox-primary checkbox-fill d-inline">
                                             <input type="checkbox" name="checkbox-fill-p-1" id="picklist_sheet" value="Y" class="mr-2">
                                             <label for="picklist_sheet" class="cr">Picklist</label>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="checkbox checkbox-primary checkbox-fill d-inline">
                                             <input type="checkbox" name="checkbox-fill-p-1" id="cover_sheet" value="Y" class="mr-2">
                                             <label for="cover_sheet" class="cr">ใบปะหน้าพัสดุ</label>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <div class="checkbox checkbox-primary checkbox-fill d-inline">
                                             <input type="checkbox" name="checkbox-fill-p-1" id="invoice_sheet" value="Y" class="mr-2">
                                             <label for="invoice_sheet" class="cr">Invoice</label>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="modal-body">
                         <button type="button" class="btn btn-primary mr-2 create-document-submit-btn"><i class="fa fa-print mr-2"></i>สร้างเอกสารที่เลือก</button>
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
               </div>
          </div>
     </div>

     {{-- <div class="modal fade adjust-status-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title h4" id="myLargeModalLabel">Large Modal</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">


                    </div>
               </div>
          </div>
     </div> --}}
@endsection
@section('js_bottom')

     <!-- jquery-validation Js -->
     <script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
     <!-- sweet alert Js -->
     <script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>
     <!-- notification Js -->
     <script src="{{asset('assets/js/plugins/bootstrap-notify.min.js')}}"></script>

     <!-- datatable Js -->
     <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/dataTables.bootstrap4.min.js') }}"></script>


     <script type="text/javascript">
     $(document).ready(function() {

          $('body').on('click', '.nav-link', function (e) {
               e.preventDefault();
               $(".order_chk").prop("checked", false);
          });

          $('body').on('change', '.order_chk_all_p', function (e) {
               e.preventDefault();
               if ($(".order_chk_all_p").prop("checked") == true) {
                    $(".order_chk_p").prop("checked", true);
               } else {
                    $(".order_chk_p").prop("checked", false);
               }
          });

          // $(".table-order").DataTable();

          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });

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

          $('body').on('click', '.create-document-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).prop("checked") == true){
                         order_arr.push($(this).val());
                    }
               });
               if (order_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    $(".create-document-modal").modal("show");
               }
          });

          $('body').on('click', '.create-document-submit-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).prop("checked") == true){
                         order_arr.push($(this).val());
                    }
               });
               if (order_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    var picklist_sheet = 'N';
                    var cover_sheet = 'N';
                    var invoice_sheet = 'N';
                    if ( $("#picklist_sheet").prop("checked") == true ) {
                         var picklist_sheet = $("#picklist_sheet").val()
                    }
                    if ( $("#cover_sheet").prop("checked") == true ) {
                         var cover_sheet = $("#cover_sheet").val();
                    }
                    if ( $("#invoice_sheet").prop("checked") == true ) {
                         var invoice_sheet = $("#invoice_sheet").val();
                    }

                    data = 'picklist_sheet=' + picklist_sheet +'&'+ 'cover_sheet=' + cover_sheet +'&'+ 'invoice_sheet=' + invoice_sheet +'&'+ 'order_id=' + order_arr;

                    url = url_gb + '/admin/order/documentPrint?' + data;
                    window.open(url, '_blank').focus();
               }
          });

          $('body').on('click', '.adjust_status_order', function (e) {
               var order_arr = [];
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).prop("checked") == true){
                         order_arr.push($(this).val());
                    }
               });
               if (order_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    $(".adjust-status-modal").modal("show");
               }
          });

          // $('body').on('change', '.order_chk', function (e) {
          //      e.preventDefault();
          //      var order_arr = [];
          //      $(".order_chk").each(function(i, obj) {
          //           if ($(this).prop("checked") == true){
          //                order_arr.push($(this).val());
          //           }
          //      });
          //      if (order_arr.length == 0){
          //           $(".adjust_status_order").removeAttr("href");
          //           $(".adjust_status_order").removeAttr("target");
          //      } else {
          //           $(".adjust_status_order").attr("href", url_gb + '/admin/order/adjustStatus/' + order_arr);
          //           $(".adjust_status_order").attr("target", "_blank");
          //      }
          // });
     });

     $('body').on('click', '.btn-delete', function (e) {
          e.preventDefault();
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
