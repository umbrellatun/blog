@inject('orderInject', 'App\Http\Controllers\Admin\OrderController')
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
                            <div class="card-body shadow border-0">
                                 <ul class="nav nav-pills nav-fill mb-3" role="tablist">
                                      <li class="nav-item">
                                           <a class="nav-link active font-weight-bold" data-toggle="tab" href="#status_all" role="tab"></i>ทั้งหมด</a>
                                           <div class="slide bg-c-blue"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold" data-toggle="tab" href="#status_w" role="tab">รอหลักฐานการชำระเงิน</a>
                                           <div class="slide bg-c-green"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold" data-toggle="tab" href="#status_wa" role="tab">รอตรวจสอบหลักฐานการชำระเงิน</a>
                                           <div class="slide bg-c-green"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold" data-toggle="tab" href="#status_p" role="tab">ที่ต้องจัดส่่ง</a>
                                           <div class="slide bg-c-red"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold" data-toggle="tab" href="#status_wt" role="tab">รอขนส่งเข้ามารับสินค้า</a>
                                           <div class="slide bg-c-yellow"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold" data-toggle="tab" href="#status_t" role="tab">อยู่ระหว่างจัดส่ง</a>
                                           <div class="slide bg-c-yellow"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold" data-toggle="tab" href="#status_s" role="tab">สำเร็จ</a>
                                           <div class="slide bg-c-yellow"></div>
                                      </li>
                                      <li class="nav-item">
                                           <a class="nav-link font-weight-bold" data-toggle="tab" href="#status_c" role="tab">ยกเลิก</a>
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
                                                                         <span class="badge badge-warning">{{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td>
                                                                         <div class="overlay-edit text-center" style="opacity: 1; background: none;">
                                                                              <a class="btn btn-info text-white" data-toggle="tooltip" title="แพ็คสินค้า" href="{{ route('pack.create', ['order_id' => $order->id]) }}" target="_blank">
                                                                                   <i class="fas fa-box-open"></i>
                                                                              </a>
                                                                         </div>
                                                                         {{-- <div class="btn-group btn-group-sm">
                                                                              <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
                                                                              <a class="btn btn-primary btn-edit text-white" href="{{ route('order.manage', ['id' => $order->id]) }}">
                                                                                   <i class="fas fa-bars"></i>
                                                                              </a>
                                                                         </div> --}}
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

     <!-- datatable Js -->
     <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('assets/js/plugins/dataTables.bootstrap4.min.js') }}"></script>

     <script type="text/javascript">
         $(document).ready(function() {

             $(".table-order").DataTable();

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

            $('body').on('click', '.print-invoice-btn', function (e) {
                 var order_arr = [];
                 $(".order_chk").each(function(i, obj) {
                      if ($(this).prop("checked") == true){
                           order_arr.push($(this).val());
                      }
                 });
                 if (order_arr.length == 0){
                      notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
                 }
            });

            $('body').on('change', '.order_chk', function (e) {
                 e.preventDefault();
                 var order_arr = [];
                 $(".order_chk").each(function(i, obj) {
                      if ($(this).prop("checked") == true){
                           order_arr.push($(this).val());
                      }
                 });
                 if (order_arr.length == 0){
                      $(".print-invoice-btn").removeAttr("href");
                      $(".print-invoice-btn").removeAttr("target");
                 } else {
                      $(".print-invoice-btn").attr("href", url_gb + '/admin/dashboard/printInvoice/' + order_arr);
                      $(".print-invoice-btn").attr("target", "_blank");
                 }

            });
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
