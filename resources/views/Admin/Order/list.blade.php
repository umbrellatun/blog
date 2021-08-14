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
                            <hr style="border-color: #5bc0de;">
                            <div class="row">
                                 <div class="col-md-12">
                                      <a href="#" class="btn waves-effect waves-light btn-info m-0 create-document-btn mr-2 mb-3"><i class="fas fa-print mr-2"></i>สร้างเอกสาร</a>
                                      @if (isset($_GET["status"]))
                                           @if ($_GET["status"] == 'FP')
                                                <a href="#" class="btn waves-effect waves-light btn-warning m-0 adjust-wait-transfer-btn mb-3"><i class="fas fa-cog mr-2"></i>ปรับสถานะ</a>
                                           @endif
                                           @if ($_GET["status"] == 'WT')
                                                <a href="#" class="btn waves-effect waves-light btn-warning m-0 adjust-shipping-btn mb-3"><i class="fas fa-truck mr-2"></i>ทำการจัดส่ง</a>
                                           @endif
                                           @if ($_GET["status"] == 'T')
                                                <a href="#" class="btn waves-effect waves-light btn-warning m-0 adjust-shipping-success-btn mb-3"><i class="fas fa-cog mr-2"></i>ปรับสถานะ</a>
                                           @endif
                                      @endif
                                      <div class="col-6">
                                           <div class="col-md-12 mb-2">
                                                <h4>ค้นหา</h4>
                                                <div class="form-group">
                                                     <label class="form-label">เอกสารการจัดส่งพัสดุ</label>
                                                     <select class="form-control" name="document_status" id="document_status">
                                                          @php
                                                          $select0 = '';
                                                          $select1 = '';
                                                          $select2 = '';
                                                          $select3 = '';
                                                          @endphp
                                                          @if (isset($_GET["document_status"]))
                                                               @if ($_GET["document_status"] == 0)
                                                                    @php
                                                                    $select0 = 'selected';
                                                                    @endphp
                                                               @endif
                                                               @if ($_GET["document_status"] == 1)
                                                                    @php
                                                                    $select1 = 'selected';
                                                                    @endphp
                                                               @endif
                                                               @if ($_GET["document_status"] == 2)
                                                                    @php
                                                                    $select2 = 'selected';
                                                                    @endphp
                                                               @endif
                                                               @if ($_GET["document_status"] == 3)
                                                                    @php
                                                                    $select3 = 'selected';
                                                                    @endphp
                                                               @endif
                                                          @endif
                                                          <option value="0" {{$select0}}>ทั้งหมด</option>
                                                          <option value="1" {{$select1}}>ยังไม่ได้พิมพ์เอกสารใด</option>
                                                          <option value="2" {{$select2}}>ยังไม่ได้พิมพ์ใบ Packlist</option>
                                                          <option value="3" {{$select3}}>ยังไม่ได้พิมพ์ใบปะหน้าสินค้า</option>
                                                     </select>
                                                </div>
                                           </div>

                                      </div>
                                 </div>
                          </div>
                          <?php
                          function classActive($status)
                          {
                               $class_active = '';
                               if (isset($_GET["status"])) {
                                    if ($_GET["status"] == $status){
                                         $class_active = 'nav-link active';
                                    }
                               }
                               return $class_active;
                          }
                           ?>
                          <hr style="border-color: #5bc0de;">
                            <div class="card-body shadow border-0">
                                 <ul class="nav nav-pills nav-fill mb-3" role="tablist">
                                      <li class="nav-item {{ isset($_GET["status"]) ? "" : 'nav-link active'}} role="tab"" >
                                           <a href="{{ route('order', ['status' => 'A', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : '')]) }}" class="font-weight-bold text-light nav-link"></i>ทั้งหมด</a>
                                      </li>
                                      <li class="nav-item {{classActive('W')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'W', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : '')]) }}" class="font-weight-bold text-light nav-link">รอหลักฐานการชำระเงิน</a>
                                      </li>
                                      <li class="nav-item {{classActive('WA')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'WA', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : '')]) }}" class="font-weight-bold text-light nav-link">รอตรวจสอบหลักฐานการชำระเงิน</a>
                                      </li>
                                      <li class="nav-item {{classActive('P')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'P', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : '')]) }}" class="font-weight-bold text-light nav-link">รอแพ็คสินค้า</a>
                                           {{-- <div class="slide bg-c-red"></div> --}}
                                      </li>
                                      <li class="nav-item {{classActive('FP')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'FP', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : '')]) }}" class="font-weight-bold text-light nav-link">สแกนครบแล้ว</a>
                                           {{-- <div class="slide bg-c-red"></div> --}}
                                      </li>
                                      <li class="nav-item {{classActive('WT')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'WT', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : ''), 'shipping_id' => 1]) }}" class="font-weight-bold text-light nav-link">รอขนส่งเข้ามารับสินค้า</a>
                                           {{-- <div class="slide bg-c-yellow"></div> --}}
                                      </li>
                                      <li class="nav-item {{classActive('T')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'T', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : ''), 'shipping_id' => 1]) }}" class="font-weight-bold text-light nav-link">อยู่ระหว่างจัดส่ง</a>
                                           {{-- <div class="slide bg-c-yellow"></div> --}}
                                      </li>
                                      <li class="nav-item {{classActive('S')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'S', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : '')]) }}" class="font-weight-bold text-light nav-link">สำเร็จ</a>
                                           {{-- <div class="slide bg-c-yellow"></div> --}}
                                      </li>
                                      <li class="nav-item {{classActive('C')}}" role="tab">
                                           <a href="{{ route('order', ['status' => 'C', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : '')]) }}" class="font-weight-bold text-light nav-link">ยกเลิก</a>
                                           {{-- <div class="slide bg-c-yellow"></div> --}}
                                      </li>
                                 </ul>
                                 <div class="tab-content mt-5">
                                      <div class="tab-pane {{ isset($_GET["status"]) ? classActive('A') : 'active'}}" id="status_all" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th class="text-center"><input type="checkbox" class="order_chk_all_p"></th>
                                                               <th class="text-left">Order no.</th>
                                                               <th class="text-left">วันที่สร้าง</th>
                                                               <th class="text-left">ลูกค้า</th>
                                                               <th class="text-left">วิธีการจัดส่ง</th>
                                                               <th class="text-right">จำนวนเงิน(บาท)</th>
                                                               <th class="text-right">จำนวนเงิน(กีบ)</th>
                                                               <th class="text-center">สถานะ</th>
                                                               {{-- <th>action</th> --}}
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
                                                                    <td class="text-center">
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk_p form-check-input order_chk_p_A" data-value="A" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td class="text-left">{{$order->order_no}}</td>
                                                                    <td class="text-left">{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td class="text-left">{{$order->Customer->name}}</td>
                                                                    <td class="text-left">{{ $order->Shipping->name }}</td>
                                                                    <td class="text-right">{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td class="text-right">{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td class="text-center">
                                                                         <span class="badge badge-light-warning"> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                         {{-- <span> {{$orderInject->GetOrderStatus($order->status)}} </span> --}}
                                                                    </td>
                                                                    {{-- <td>
                                                                         <div class="btn-group btn-group-sm">
                                                                              <a class="btn btn-warning btn-edit text-white" href="{{ route('order.edit', ['id' => $order->id]) }}">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
                                                                              <a class="btn btn-primary btn-edit text-white" href="{{ route('order.manage', ['id' => $order->id]) }}">
                                                                                   <i class="fas fa-bars"></i>
                                                                              </a>
                                                                         </div>
                                                                    </td> --}}
                                                               </tr>
                                                          @endforeach
                                                     </tbody>
                                                </table>
                                           </div>
                                      </div>
                                      <div class="tab-pane {{classActive('W')}}" id="status_w" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th><input type="checkbox" class="order_chk_all_p"></th>
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
                                                                                   <input type="checkbox" class="order_chk_p form-check-input order_chk_p_w" data-value="{{$order->status}}" value="{{$order->id}}">
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
                                      </div>
                                      <div class="tab-pane {{classActive('WA')}}" id="status_wa" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th class="text-center"><input type="checkbox" class="order_chk_all_p"></th>
                                                               <th class="text-left">Order no.</th>
                                                               <th class="text-left">วันที่สร้าง</th>
                                                               <th class="text-left">ลูกค้า</th>
                                                               <th class="text-left">วิธีการจัดส่ง</th>
                                                               <th class="text-right">จำนวนเงิน(บาท)</th>
                                                               <th class="text-right">จำนวนเงิน(กีบ)</th>
                                                               <th class="text-center">สถานะ</th>
                                                               <th class="text-center">action</th>
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
                                                               <tr id="tr_wa_{{$order->id}}">
                                                                    <td class="text-center">
                                                                         <div class="form-group">
                                                                              <div class="form-check">
                                                                                   <input type="checkbox" class="order_chk_p form-check-input order_chk_p_WA" data-value="WA" value="{{$order->id}}">
                                                                              </div>
                                                                         </div>
                                                                    </td>
                                                                    <td class="text-left">{{$order->order_no}}</td>
                                                                    <td class="text-left">{{ date_format($order->created_at, 'd M Y')}}</td>
                                                                    <td class="text-left">{{$order->Customer->name}}</td>
                                                                    <td class="text-left">{{ $order->Shipping->name }}</td>
                                                                    <td class="text-right">{{ number_format($sum_product_bath + $sum_box_bath, 2)}}</td>
                                                                    <td class="text-right">{{ number_format($sum_product_lak + $sum_box_lak, 2)}}</td>
                                                                    <td class="text-center">
                                                                         <span class="badge badge-light-warning"> {{$orderInject->GetOrderStatus($order->status)}} </span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                         <div class="overlay-edit text-center" style="opacity: 1; background: none;">
                                                                              <a class="btn btn-warning btn-edit text-white" data-toggle="tooltip" title="แก้ไขรายการสั่งซื้อ" href="{{ route('order.edit', ['id' => $order->id]) }}" target="_blank">
                                                                                   <i class="ace-icon feather icon-edit-1 bigger-120"></i>
                                                                              </a>
                                                                              <a href="#" class="btn waves-effect waves-light btn-info view-transfer-slip-btn" data-id="{{$order->id}}" data-toggle="tooltip" title="ดูหลักฐานการโอนทั้งหมด">
                                                                                   <i class="fa fa-eye"></i>
                                                                              </a>
                                                                         </div>
                                                                    </td>
                                                               </tr>
                                                          @endforeach
                                                     </tbody>
                                                </table>
                                           </div>
                                      </div>
                                      <div class="tab-pane {{classActive('P')}}" id="status_p" role="tabpanel">
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
                                                                         <input type="checkbox" class="order_chk_p order_chk_p_P" data-value="P" value="{{$order->id}}">
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
                                      </div>
                                      <div class="tab-pane {{classActive('FP')}}" id="status_fp" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th><input type="checkbox" class="order_chk_all_p"></th>
                                                               <th>Order no.</th>
                                                               <th>วันที่สร้าง</th>
                                                               <th>ลูกค้า</th>
                                                               <th>จำนวนเงิน(บาท)</th>
                                                               <th>จำนวนเงิน(กีบ)</th>
                                                               <th>วิธีการจัดส่ง</th>
                                                               <th>สถานะ</th>
                                                               <th>พิมพ์แล้ว</th>
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
                                                                         <input type="checkbox" class="order_chk_p order_chk_p_FP" data-value="FP" value="{{ $order->id}}">
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
                                                                    <td>{{ $orderInject->getPrinted($order->id) }}</td>
                                                                    <td>
                                                                         <div class="overlay-edit text-center" style="opacity: 1; background: none;">
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
                                                {{-- <button class="btn btn-outline-primary btn-round btn-sm"></button> --}}
                                                {{ $orders->links() }}
                                           </div>
                                      </div>
                                      <div class="tab-pane {{classActive('WT')}}" id="status_wt" role="tabpanel">
                                           <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                @foreach ($shippings as $key => $shipping)
                                                     @if (isset($_GET["shipping_id"]))
                                                          @if ($_GET["shipping_id"] == $shipping->id)
                                                               @php
                                                                    $shipping_class_active = 'active';
                                                                    $get_shipping_id = $_GET["shipping_id"];
                                                               @endphp
                                                          @else
                                                               @php
                                                               $shipping_class_active = '';
                                                               $get_shipping_id  = '';
                                                               @endphp
                                                          @endif
                                                     @else
                                                          @php
                                                          $shipping_class_active = '';
                                                          $get_shipping_id  = '';
                                                          @endphp
                                                     @endif
                                                     <li class="nav-item nav-link {{$shipping_class_active}} w-15 text-center rounded border border-primary m-2">
                                                          <a href="{{ route('order', ['status' => 'WT', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : ''), 'shipping_id' => $shipping->id]) }}" class="nav-link nav-link-shipping text-light">
                                                               <i class="fa fa-truck mr-2" aria-hidden="true"></i>
                                                               {{ $shipping->name }}
                                                               ({{ count($orders->where('shipping_id', $shipping->id)) }})
                                                          </a>
                                                     </li>
                                                @endforeach
                                           </ul>
                                           @foreach ($shippings as $key => $shipping)
                                                @if (isset($_GET["shipping_id"]))
                                                     @if ($_GET["shipping_id"] == $shipping->id)
                                                          @php
                                                          $shipping_class_active = 'nav-link active';
                                                          $get_shipping_id = $_GET["shipping_id"];
                                                          @endphp
                                                     @else
                                                          @php
                                                          $shipping_class_active = '';
                                                          $get_shipping_id  = '';
                                                          @endphp
                                                     @endif
                                                @else
                                                     @php
                                                     $shipping_class_active = '';
                                                     $get_shipping_id  = '';
                                                     @endphp
                                                @endif
                                                @if (sizeof($orders->where('status', 'WT')->where('shipping_id', $get_shipping_id)) > 0)
                                                     <div class="tab-pane {{$shipping_class_active}}" class="shipping-tab" id="shipping-tab{{$shipping->id}}" role="tabpanel">
                                                          <div class="table-responsive">
                                                               <table class="table table-order">
                                                                    <thead>
                                                                         <tr>
                                                                              <th><input type="checkbox" class="order_chk_all_p"></th>
                                                                              <th>Order no.</th>
                                                                              <th>วันที่สร้าง</th>
                                                                              <th>ลูกค้า</th>
                                                                              <th>จำนวนเงิน(บาท)</th>
                                                                              <th>จำนวนเงิน(กีบ)</th>
                                                                              <th>วิธีการจัดส่ง</th>
                                                                              <th>สถานะ</th>
                                                                              <th>พิมพ์แล้ว</th>
                                                                              <th>action</th>
                                                                         </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                         @foreach ($orders->where('status', 'WT')->where('shipping_id', $shipping->id) as $order)
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
                                                                              <tr class="tr_order_{{$order->id}}">
                                                                                   <td>
                                                                                        <div class="form-group">
                                                                                             <div class="form-check">
                                                                                                  <input type="checkbox" class="order_chk_p form-check-input order_chk_p_WT" data-value="WT" value="{{$order->id}}">
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
                                                                                   <td>{{ $orderInject->getPrinted($order->id) }}</td>
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
                                                     </div>
                                                @endif
                                           @endforeach
                                      </div>
                                      <div class="tab-pane {{classActive('T')}}" id="status_t" role="tabpanel">
                                           <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                @foreach ($shippings as $key => $shipping)
                                                     @if (isset($_GET["shipping_id"]))
                                                          @if ($_GET["shipping_id"] == $shipping->id)
                                                               @php
                                                                    $shipping_class_active = 'active';
                                                                    $get_shipping_id = $_GET["shipping_id"];
                                                               @endphp
                                                          @else
                                                               @php
                                                               $shipping_class_active = '';
                                                               $get_shipping_id  = '';
                                                               @endphp
                                                          @endif
                                                     @else
                                                          @php
                                                          $shipping_class_active = '';
                                                          $get_shipping_id  = '';
                                                          @endphp
                                                     @endif
                                                     <li class="nav-item nav-link {{$shipping_class_active}} w-15 text-center rounded border border-primary m-2">
                                                          <a href="{{ route('order', ['status' => 'T', 'document_status' => (isset($_GET["document_status"]) ? $_GET["document_status"] : ''), 'shipping_id' => $shipping->id]) }}" class="nav-link nav-link-shipping text-light">
                                                               <i class="fa fa-truck mr-2" aria-hidden="true"></i>
                                                               {{ $shipping->name }}
                                                               ({{ count($orders->where('shipping_id', $shipping->id)) }})
                                                          </a>
                                                     </li>
                                                @endforeach
                                           </ul>
                                           @foreach ($shippings as $key => $shipping)
                                                @if (isset($_GET["shipping_id"]))
                                                     @if ($_GET["shipping_id"] == $shipping->id)
                                                          @php
                                                          $shipping_class_active = 'nav-link active';
                                                          $get_shipping_id = $_GET["shipping_id"];
                                                          @endphp
                                                     @else
                                                          @php
                                                          $shipping_class_active = '';
                                                          $get_shipping_id  = '';
                                                          @endphp
                                                     @endif
                                                @else
                                                     @php
                                                     $shipping_class_active = '';
                                                     $get_shipping_id  = '';
                                                     @endphp
                                                @endif
                                                @if (sizeof($orders->where('status', 'T')->where('shipping_id', $get_shipping_id)) > 0)
                                                     <div class="tab-pane {{$shipping_class_active}}" class="shipping-tab" id="shipping-tab{{$shipping->id}}" role="tabpanel">
                                                          <div class="table-responsive">
                                                               <table class="table table-order">
                                                                    <thead>
                                                                         <tr>
                                                                              <th><input type="checkbox" class="order_chk_all_p"></th>
                                                                              <th>Order no.</th>
                                                                              <th>วันที่สร้าง</th>
                                                                              <th>ลูกค้า</th>
                                                                              <th>จำนวนเงิน(บาท)</th>
                                                                              <th>จำนวนเงิน(กีบ)</th>
                                                                              <th>วิธีการจัดส่ง</th>
                                                                              <th>สถานะ</th>
                                                                              <th>พิมพ์แล้ว</th>
                                                                              <th>action</th>
                                                                         </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                         @foreach ($orders->where('status', 'T')->where('shipping_id', $shipping->id) as $order)
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
                                                                              <tr class="tr_order_t_{{$order->id}}">
                                                                                   <td>
                                                                                        <div class="form-group">
                                                                                             <div class="form-check">
                                                                                                  <input type="checkbox" class="order_chk_p form-check-input order_chk_p_T" data-value="T" value="{{$order->id}}">
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
                                                                                   <td>{{ $orderInject->getPrinted($order->id) }}</td>
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
                                                     </div>
                                                @endif
                                           @endforeach
                                      </div>
                                      <div class="tab-pane {{classActive('S')}}" id="status_s" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th><input type="checkbox" class="order_chk_all_p"></th>
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
                                                                         <input type="checkbox" class="order_chk_p form-check-input order_chk_p_S" data-value="S" value="{{$order->id}}">
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
                                      </div>
                                      <div class="tab-pane {{classActive('C')}}" id="status_c" role="tabpanel">
                                           <div class="table-responsive">
                                                <table class="table table-order">
                                                     <thead>
                                                          <tr>
                                                               <th><input type="checkbox" class="order_chk_all_p"></th>
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
                                                                                   <input type="checkbox" class="order_chk_p form-check-input order_chk_p_C" data-value="C" value="{{$order->id}}">
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
                         <button type="button" class="btn  btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ยกเลิก</button>
                    </div>
               </div>
          </div>
     </div>

     <div class="modal fade adjust-wait-transfer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel"><i class="fa fa-cog mr-2" aria-hidden="true"></i>ปรับสถานะ</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <h2>สินค้าสแกนครบแล้ว คุณต้องการปรับสถานะ
                              <br/>เป็น<span class="text-primary"> "รอขนส่งเข้ามารับสินค้า"</span> ใช่หรือไม่?</h2>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-success adjust-wait-transfer-submit-btn"><i class="fa fa-check mr-2" aria-hidden="true"></i>ยืนยัน</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ยกเลิก</button>
                    </div>
               </div>
          </div>
     </div>

     <div class="modal fade adjust-shipping-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel"><i class="fa fa-cog mr-2" aria-hidden="true"></i>ปรับสถานะ</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         {{-- <h2>สินค้าสแกนครบแล้ว คุณต้องการปรับสถานะ
                              <br/>เป็น<span class="text-primary"> "อยู่ระหว่างจัดส่ง"</span> ใช่หรือไม่?</h2> --}}
                         <div class="form-group mb-2 col-12">
                              <input type="text" id="qr_code" class="form-control" placeholder="สแกน Qr-Code ที่นี่">
                         </div>
                    </div>
                    <div class="modal-footer">
                         {{-- <button type="button" class="btn btn-primary reset-qr-code-btn"><i class="fa fa-refresh" aria-hidden="true"></i></i>Reset</button> --}}
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ยกเลิก</button>
                    </div>
               </div>
          </div>
     </div>

     <div class="modal fade adjust-success-shipping-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel"><i class="fa fa-cog mr-2" aria-hidden="true"></i>ปรับสถานะ</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <h2>สินค้าสแกนครบแล้ว คุณต้องการปรับสถานะ
                              <br/>เป็น<span class="text-primary"> "จัดส่งสำเร็จ"</span> ใช่หรือไม่?</h2>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-success adjust-success-shipping-submit-btn"><i class="fa fa-check mr-2" aria-hidden="true"></i>ยืนยัน</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ยกเลิก</button>
                    </div>
               </div>
          </div>
     </div>

     <div class="modal fade view-transfer-slip-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel">หลักฐานการโอน</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <div class="table-responsive">
                              <table class="table" id="transfer_table">
                                   <thead>
                                        <tr>
                                             <th>#</th>
                                             <th>ชื่อไฟล์</th>
                                             <th>จำนวนเงิน</th>
                                             <th>วันที่โอน</th>
                                             <th>เวลาโอน</th>
                                             <th>หมายเหตุ</th>
                                             <th>สถานะ</th>
                                             <th>ผู้รับเงิน</th>
                                             <th>action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                              </table>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-primary btn-check-transfer"><i class="fa fa-check mr-2" aria-hidden="true"></i>ตรวจสอบแล้ว</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                    </div>
               </div>
          </div>
     </div>

     <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-body text-center">
                         <img src="{{asset('assets/images/product/prod-0.jpg')}}" id="transfer_slip_img" style=" height: 400px; width: 300px;"></img>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-danger btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                         {{-- <button type="button" class="btn  btn-primary">Save changes</button> --}}
                    </div>
               </div>
          </div>
     </div>

@endsection
@section('js_bottom')
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

     function inArray(needle, haystack) {
          var length = haystack.length;
          for(var i = 0; i < length; i++) {
               if(typeof haystack[i] == 'object') {
                    if(arrayCompare(haystack[i], needle)) return true;
               } else {
                    if(haystack[i] == needle) return true;
               }
          }
          return false;
     }

     function unique(array){
          return array.filter(function(el, index, arr) {
               return index == arr.indexOf(el);
          });
     }

     $(document).ready(function() {
          $(".order_chk_all_p").prop("checked", false);
          $(".order_chk_p").prop("checked", false);

          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });

          $('body').on('change', '.order_chk_all_p', function (e) {
               e.preventDefault();
               if ($(this).prop("checked") == true) {
                    $(".order_chk_p").prop("checked", true);
               } else {
                    $(".order_chk_p").prop("checked", false);
               }
          });

          $('body').on('change', '.order_chk_p', function (e) {
               e.preventDefault();
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : '' }}';
               order_arr = [];
               $(".order_chk_p_" + status).each(function(i, obj) {
                    order_arr.push($(this).prop("checked"));
               });
               if(inArray(false, order_arr)){
                    $(".order_chk_all_p").prop("checked", false);
               } else {
                    $(".order_chk_all_p").prop("checked", true);
               }
          });

          $('body').on('change', '#document_status', function (e) {
               e.preventDefault();
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : 'A' }}';
               if ($(this).val()) {
                    urls = url_gb + '/admin/order?status=' + status + '&document_status=' + $(this).val();
                    window.location.href = urls;
               }
          });

          $('body').on('click', '.create-document-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : '' }}';
               $(".order_chk_p_"+status).each(function(i, obj) {
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

          $('body').on('click', '.view-transfer-slip-btn', function (e) {
               e.preventDefault();
               var order_id = $(this).data("id");
               $.ajax({
                    method : "post",
                    url : '{{ route('order.getTranfersView') }}',
                    data : { "order_id" : order_id },
                    dataType : 'json',
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                         $("#transfer_table tbody").empty();
                         $(".btn-check-transfer").attr('data-value', "");
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    var html = '';
                    if(rec.status==1){
                         $.each(rec.transfers, function( index, transfer ) {
                              html += '<tr>';
                              html += '<td>';
                              if (transfer.status == 'Y') {
                                   html += '';
                              } else {
                                   html += '<input type="checkbox" class="transfer_chk" value="'+transfer.id+'">';
                              }
                              html += '</td>';
                              html += '<td>'+transfer.image+'</td>';
                              html += '<td>'+transfer.amount+'</td>';
                              html += '<td>'+transfer.transfer_date+'</td>';
                              html += '<td>'+ (transfer.transfer_hours.padStart(2, '0'))  + ":" + (transfer.transfer_minutes.padStart(2, '0')) +'</td>';
                              html += '<td>'+ ((transfer.remark) ? transfer.remark : '-') +'</td>';
                              html += '<td><span class="badge '+((transfer.status == 'Y') ? 'badge-light-success' : 'badge-light-warning')+'">'+ ((transfer.status == 'Y') ? 'ตรวจสอบแล้ว' : 'รอตรวจสอบ') +'</span></td>';
                              html += '<td>'+transfer.payee_id+'</td>';
                              html += '<td>';
                              html += '<a href="#" class="btn btn-success btn-view" data-toggle="modal" data-value="'+transfer.id+'" title="ดูหลักฐานการโอน">';
                              html += '<i class="fa fa-eye"></i>';
                              html += '</a>';
                              html += '</td>';
                              html += '</tr>';
                         });
                         $("#transfer_table tbody").append(html);
                         $(".view-transfer-slip-modal").modal("show");
                         $(".btn-check-transfer").attr('data-value', order_id);


                    } else {

                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });
          });

          $('body').on('click','.btn-view',function(e){
               e.preventDefault();
               $.ajax({
                    method : "POST",
                    url : '{{ route('transfer.getimage') }}',
                    dataType : 'json',
                    data : {"data" : $(this).data("value")},
               }).done(function(rec){
                    $("#exampleModalLiveLabel").text(rec.order.order_no);
                    $("#transfer_slip_img").attr("src", '{{asset('uploads/transfers/')}}' + '/' + rec.image);
                    $("#exampleModalLive").modal('show');
               }).fail(function(){

               });
          });

          $('body').on('click','.btn-check-transfer',function(e){
               e.preventDefault();
               var order_id = $(this).data("value");
               var transfer_arr = [];
               $(".transfer_chk").each(function(i, obj) {
                    if ($(this).prop("checked") == true){
                         transfer_arr.push($(this).val());
                    }
               });
               if (transfer_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    $.ajax({
                         method : "POST",
                         url : '{{ route('order.SaveTranfersView') }}',
                         dataType : 'json',
                         data : {"data" : transfer_arr, "order_id" : order_id},
                    }).done(function(rec){
                         if (rec.status == 1){
                              notify("top", "right", "feather icon-layers", "success", "", "", rec.content);
                              if (rec.remove_order == 1){
                                   $(".view-transfer-slip-modal").modal('hide');
                                   $("#tr_wa_" + order_id).remove();
                              }
                         }

                    }).fail(function(){

                    });
               }

          });


          $('body').on('click', '.adjust-wait-transfer-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : '' }}';
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).data("value") == status) {
                         if ($(this).prop("checked") == true){
                              order_arr.push($(this).val());
                         }
                    }
               });
               if (order_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    $(".adjust-wait-transfer-modal").modal("show");
               }
          });

          $('body').on('click', '.adjust-shipping-success-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : '' }}';
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).data("value") == status) {
                         if ($(this).prop("checked") == true){
                              order_arr.push($(this).val());
                         }
                    }
               });
               if (order_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    $(".adjust-success-shipping-modal").modal("show");
               }
          });

          $('body').on('click', '.create-document-submit-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : '' }}';
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).data("value") == status) {
                         if ($(this).prop("checked") == true){
                              order_arr.push($(this).val());
                         }
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

          $('body').on('click', '.adjust-wait-transfer-submit-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : '' }}';
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).data("value") == status) {
                         if ($(this).prop("checked") == true){
                              order_arr.push($(this).val());
                         }
                    }
               });
               if (order_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    $.ajax({
                         method : "post",
                         url : '{{ route('order.adjustStatusMultiOrder') }}',
                         data : { "order_ids" : order_arr },
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
                                   location.reload();
                              });
                         } else {
                              notify("top", "right", "feather icon-layers", "danger", "", "", "");
                         }
                    }).fail(function(){
                         $("#preloaders").css("display", "none");
                         swal("", rec.content, "error");
                    });
               }
          });

          $('body').on('click', '.adjust-shipping-btn', function (e) {
               e.preventDefault();
               $(".adjust-shipping-modal").modal("show");
               $("#qr_code").focus();
          });

          $("#qr_code").keypress(function(e){
               if(e.which == 13) {
                    // $("#preview_img").attr("src", '{{asset('assets/images/product/prod-0.jpg')}}');
                    $.ajax({
                         method : "POST",
                         data : {"data" : $(this).val()},
                         url : '{{ route('order.adjustStatusToShipping') }}',
                         dataType : 'json',
                         beforeSend: function() {
                              $("#preloaders").css("display", "block");
                         },
                    }).done(function(rec){
                         if(rec.status == 1){
                              $(".tr_order_" + rec.order_id).remove();
                              notify("top", "right", "feather icon-layers", "success", "", "", "บันทึกข้อมูลเรียบร้อยแล้ว");
                         } else {
                              notify("top", "right", "feather icon-layers", "danger", "", "", rec.content);
                         }
                         $("#preloaders").css("display", "none");
                         $("#qr_code").val('');
                    }).fail(function(){
                         $("#preloaders").css("display", "none");
                         swal("system.system_alert","system.system_error","error");
                    });
               }
          });

          $('body').on('click', '.adjust-success-shipping-submit-btn', function (e) {
               e.preventDefault();
               var order_arr = [];
               var status = '{{ isset($_GET["status"]) ? $_GET["status"] : '' }}';
               $(".order_chk_p").each(function(i, obj) {
                    if ($(this).data("value") == status) {
                         if ($(this).prop("checked") == true){
                              order_arr.push($(this).val());
                         }
                    }
               });
               if (order_arr.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               } else {
                    $.ajax({
                         method : "post",
                         url : '{{ route('order.adjustStatusSuccessShipping') }}',
                         data : { "order_ids" : order_arr },
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
                                   location.reload();
                              });
                         } else {
                              notify("top", "right", "feather icon-layers", "danger", "", "", "");
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
