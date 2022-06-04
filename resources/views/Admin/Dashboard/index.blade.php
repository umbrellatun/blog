@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<!-- data tables css -->
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
@section('css_bottom')
@endsection
@section('body')
     <div class="pcoded-content">
          <!-- [ breadcrumb ] start -->
          {{-- <div class="page-header">
               <div class="page-block">
                    <div class="row align-items-center">
                         <div class="col-md-12">
                              <div class="page-header-title">
                                   <h5 class="m-b-10">Dashboard</h5>
                              </div>
                              <ul class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                   <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                              </ul>
                         </div>
                    </div>
               </div>
          </div> --}}
          <!-- [ breadcrumb ] end -->
          <!-- [ Main Content ] start -->
          <div class="row">
               <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-yellow order-card" style="height: 160px;">
                         <div class="card-body">
                              <h6 class="text-white">Orders ทั้งหมด</h6>
                              <h2 class="text-right text-white"><i class="fas fa-database text-white float-left"></i><span>{{ count($orders) }}</span></h2>
                              <p class="m-b-0">จัดส่งสำเร็จ<span class="float-right">{{ count($orders->where('status', 'S')) }}</span></p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-green order-card" style="height: 160px;">
                         <div class="card-body">
                              <h6 class="text-white">ยอดเงินบาททั้งหมด</h6>
                              <div class="row align-items-center m-b-25">
                                   <div class="col-auto">
                                        <img src="{{asset('assets/images/currency/TH.png')}}" style="width: 50px;">
                                   </div>
                                   <div class="col text-right">
                                        <h3 class="m-b-5 text-white">{{number_format($total_thb)}}</h3>
                                   </div>
                              </div>
                              <p class="m-b-0">จัดส่งสำเร็จ<span class="float-right">{{ number_format($total_suc_thb)}}</span></p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-red order-card" style="height: 160px;">
                         <div class="card-body">
                              <h6 class="text-white">ยอดเงินกีบทั้งหมด</h6>
                              <div class="row align-items-center m-b-25">
                                   <div class="col-auto">
                                        <img src="{{asset('assets/images/currency/laos.png')}}" style="width: 50px;">
                                   </div>
                                   <div class="col text-right">
                                        <h3 class="m-b-5 text-white">{{number_format($total_lak)}}</h3>
                                   </div>
                              </div>
                              <p class="m-b-0">จัดส่งสำเร็จ<span class="float-right">{{ number_format($total_suc_lak)}}</span></p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-blue order-card" style="height: 160px;">
                         <div class="card-body">
                              <h6 class="text-white">ลูกค้าทั้งหมด</h6>
                              <h2 class="text-right text-white"><i class="fas fa-users f-18 analytic-icon float-left"></i><span>{{ count($customers) }}</span></h2>
                              <p class="m-b-0">ลูกค้าที่สั่งสินค้า<span class="float-right">{{ count($orders->unique('customer_id')) }}</span></p>
                         </div>
                    </div>
               </div>
          </div>
          <div class="row">
               <div class="col-md-6 col-xl-3">
                    <div class="card">
                         <div class="card-body">
                              <h6 class="text-primary">จำนวนออเดอร์ที่เปิด(%)</h6>
                              <div class="row d-flex align-items-center">
                                   <div class="col-6 pr-0">
                                       @php
                                            $bg_arr = ["#4099ff", "#0e9e4a", "#00bcd4", "#FFB64D", "#FF5370"];
                                       @endphp
                                       @foreach ($admins as $key => $admin)
                                             <span class="d-block mb-1"><i class="fas fa-circle f-10 m-r-5" style="color: {{$bg_arr[$key]}}"></i>{{ $admin_name_arr[$key] }} {{ count($admin->Order) }}</span>
                                       @endforeach
                                  </div>
                                  <div class="col-6">
                                       <div id="device-chart"></div>
                                  </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-xl-3">
                    <div class="card bg-c-blue order-card" style="height: 160px;">
                         <div class="card-body">
                              <h6 class="text-white">สินค้าคงเหลือในโกดัง</h6>
                              <h2 class="text-right text-white"><i class="fas fa-tags text-white float-left"></i><span>{{$products->sum('in_stock')}} ชิ้น</span></h2>
                              <p class="m-b-0"><span class="float-right">{{ count($products) }} รายการสินค้า</span></p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-xl-3">
                    <div class="card bg-info order-card" style="height: 160px;">
                         <div class="card-body">
                              <h6 class="text-white">Partner ทั้งหมด</h6>
                              <h2 class="text-right text-white"><i class="fas fa-warehouse text-white float-left"></i><span>{{ count($companies) }}</span></h2>
                              <p class="m-b-0"><span class="float-right">ร้านค้า</span></p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-xl-3">
                    <div class="card bg-info order-card" style="height: 160px;">
                         <div class="card-body">
                              <h6 class="text-white">ขนส่งของเรา</h6>
                              <h2 class="text-right text-white"><i class="fa fa-truck text-white float-left"></i><span>{{ count($shippings) }}</span></h2>
                              <p class="m-b-0">อยู่ในระหว่างขนส่ง<span class="float-right">{{ number_format(count($orders->where('status', 'T')))}} ออเดอร์</span></p>
                         </div>
                    </div>
               </div>
          </div>
          <div class="row">
               <div class="col-xl-9">
                    <div class="card">
                         <div class="card-header">
                              <h5><i class="fas fa-wallet mr-2"></i>Wallet ของ Admin {{$user->name}} {{$user->lastname}}</h5>
                         </div>
                         <div class="card-body">
                              <div class="row">
                                  @foreach ($currencies as $key => $currency)
                                       <div class="col-xl-6 col-md-6">
                                            <div class="card analytic-card {{$currency->bgcolor}}">
                                                 <div class="card-body">
                                                      <div class="row align-items-center m-b-25">
                                                           <div class="col-auto">
                                                                <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 50px;">
                                                           </div>
                                                           <div class="col text-right">
                                                                @if ($key == 0)
                                                                     <h3 class="m-b-5 text-white">{{  number_format($user_orders->sum('receive_money_thb'), 2) }}</h3>
                                                                @else
                                                                     <h3 class="m-b-5 text-white">{{  number_format($user_orders->sum('receive_money_lak'), 2) }}</h3>
                                                                @endif
                                                                <h6 class="m-b-0 text-white">{{$currency->name}}</h6>
                                                           </div>
                                                      </div>
                                                      <h5 class="text-white d-inline-block m-b-0 m-l-10">{{$currency->name_th}}</h5>
                                                 </div>
                                            </div>
                                       </div>
                                  @endforeach
                             </div>
                             <div class="row">
                                  <a href="#" class="btn waves-effect waves-light btn-primary mb-2" id="transfer-ceo-btn" data-toggle="tooltip" title="โอนเงินให้ CEO">
                                       <i class="fas fa-exchange-alt mr-2"></i>ทำการโอนเงินให้ CEO
                                       {{-- {{$user->Company->name}} --}}
                                  </a>
                                  <div class="table-responsive">
                                      <table id="order_self" class="table table-hover m-b-0">
                                           <thead>
                                                <tr>
                                                     <th class="text-center"><input type="checkbox" class="order_chk_all_p"/></th>
                                                     <th class="text-center">No.</th>
                                                     <th class="text-left">Order No.</th>
                                                     <th class="text-center">โอนเล้ว(THB)</th>
                                                     <th class="text-center">โอนเล้ว(LAK)</th>
                                                     <th class="text-center">เก็บเงินปลายทาง(THB)</th>
                                                     <th class="text-center">เก็บเงินปลายทาง(LAK)</th>
                                                     <th class="text-center">ค่าขนส่งจริง(THB)</th>
                                                     <th class="text-center">ค่าขนส่งจริง(LAK)</th>
                                                     <th class="text-center">หมายเหตุ</th>
                                                     <th class="text-center">วันที่ได้รับเงิน</th>
                                                     <th class="text-center">action</th>
                                                </tr>
                                           </thead>
                                           <tbody>
                                                @if (count($user_orders) > 0)
                                                     @php
                                                          $i = 1;
                                                     @endphp
                                                     @foreach ($user_orders as $key => $user_order)
                                                          @php
                                                               $amount_thb = 0;
                                                               $amount_lak = 0;
                                                          @endphp
                                                          @if ($user_order->Order->Transfer)
                                                               @foreach ($user_order->Order->Transfer as $key => $Transfer)
                                                                    @if ($Transfer->currency_id == 1)
                                                                         @php
                                                                              $amount_thb = $amount_thb + $Transfer->amount;
                                                                         @endphp
                                                                    @endif
                                                                    @if ($Transfer->currency_id == 2)
                                                                         @php
                                                                              $amount_lak = $amount_lak + $Transfer->amount;
                                                                         @endphp
                                                                    @endif
                                                               @endforeach
                                                          @endif
                                                          <tr>
                                                               <td class="text-center"><input type="checkbox" class="order_chk_p" value="{{$user_order->Order->id}}"/></td>
                                                               <td class="text-center">{{$i}}</td>
                                                               <td class="text-left">{{$user_order->Order->order_no}}</td>
                                                               <td class="text-center">{{ number_format($amount_thb) }}</td>
                                                               <td class="text-center">{{ number_format($amount_lak) }}</td>
                                                               <td class="text-center">{{ number_format($user_order->receive_money_thb, 2) }}</td>
                                                               <td class="text-center">{{ number_format($user_order->receive_money_lak, 2) }}</td>
                                                               <td class="text-center">{{ number_format($user_order->real_shipping_cost_thb, 2) }}</td>
                                                               <td class="text-center">{{ number_format($user_order->real_shipping_cost_lak, 2) }}</td>
                                                               {{-- <td class="text-center">{{ number_format($user_order->Order->receive_money, 2)}}</td> --}}
                                                               {{-- <td class="text-center">{{$user_order->Currency->name}}</td> --}}
                                                               <td class="text-center">{{ isset($user_order->Order->remark) ? $user_order->Order->remark : '-' }}</td>
                                                               <td class="text-center">{{ $user_order->Order->received_at }}</td>
                                                               <td class="text-left">
                                                                    <div class="overlay-edit" style="opacity: 1; background: none;">
                                                                        <button class="btn btn-info btn-get-info" data-value="{{$user_order->order_id}}" data-toggle="tooltip" title="ดูข้อมูล" href="">
                                                                             <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                                        </button>
                                                                         {{-- <a href="#" class="btn waves-effect waves-light btn-primary" data-id="{{$user_order->order_id}}" data-toggle="tooltip" title="โอนเงินให้ CEO">
                                                                              ทำการโอนเงิน
                                                                         </a> --}}
                                                                         {{-- <a class="btn btn-warning text-white" data-toggle="tooltip" title="ใบแพ็คสินค้า" href="{{ route('order.coverSheet', ['id' => $user_order->order_id]) }}" target="_blank">
                                                                             <i class="fas fa-print"></i>
                                                                        </a> --}}
                                                                         @if (sizeof($user_order->Order->Transfer) > 0)
                                                                              <a href="#" class="btn waves-effect waves-light btn-info view-transfer-slip-btn" data-id="{{$user_order->order_id}}" data-toggle="tooltip" title="ดูหลักฐานการโอนทั้งหมด">
                                                                                   <i class="fa fa-eye"></i>
                                                                              </a>
                                                                         @endif

                                                                    </div>
                                                               </td>
                                                          </tr>
                                                          @php
                                                               $i++;
                                                          @endphp
                                                     @endforeach
                                                @else
                                                     <tr>
                                                          <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                                                     </tr>
                                                @endif

                                           </tbody>
                                      </table>
                                      {{ $user_orders->links() }}
                                 </div>
                                 <span class="text-info">ผลการค้นหาทั้งหมด {{$user_orders->total()}} รายการ</span>
                             </div>


                         </div>
                    </div>
               </div>
               <div class="col-xl-3">
                    <div class="card">
                         <div class="card-header">
                              <h5 class="text-primary"><i class="fa fa-truck mr-2" aria-hidden="true"></i>ออเดอร์ที่อยู่ระหว่างกำลังจัดส่ง</h5>
                         </div>
                         <div class="card-body">
                              @foreach ($shippings as $key => $shipping)
                                   <div class="row m-b-25 align-items-center">
                                        <div class="col-auto p-r-0">
                                             {{-- <i class="fa fa-truck badge-light-primary feed-icon"></i> --}}
                                             <h6 class="m-b-5">{{$shipping->name}}</h6>
                                        </div>
                                        <div class="col text-right">
                                             {{-- <a href="{{ route('shipping', ['id' => $shipping->id]) }}">
                                                  <h6 class="m-b-5">{{$shipping->name}} <span class="text-muted float-right f-14">{{ count($shipping->ShippingOrder->where('status', 'S')) }}</span></h6>
                                             </a> --}}
                                             <a href="#" class="btn waves-effect waves-light btn-info shipping-detail-btn" data-id="{{$shipping->id}}" data-toggle="tooltip" title="ดูสินค้าที่กำลังขนส่ง">
                                                  {{ count($shipping->ShippingOrder->where('status', 'S')) }}
                                             </a>
                                        </div>
                                   </div>
                              @endforeach
                         </div>
                    </div>
               </div>
          </div>
     </div>
@endsection
@section('modal')
     <div class="modal fade view-transfer-slip-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
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

     <div class="modal fade view-shipping-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title shipping_name" id="exampleModalLiveLabel"></h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <div class="table-responsive">
                              <div class="dt-responsive table-responsive">
                                   <table id="shipping_table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                   </table>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                    </div>
               </div>
          </div>
     </div>

     <div class="modal fade transfer-ceo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel">โอนเงินเข้าบริษัท</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <form id="FormAttachFile">
                              <div class="row">
                                   <div class="col-6 text-center">
                                        <div class="card">
                                             <div class="card-header">
                                                  <h5>เงินบาท</h5>
                                             </div>
                                             <div class="card-body">
                                                  <div class="form-group">
                                                       <img id="preview_img_thb" src="{{asset('assets/images/product/prod-0.jpg')}}" alt="" style=" height: 250px; width: 250px;" />
                                                       <div class="mt-3">
                                                            <input type="file" onchange="readURL(this);" class="btn-warning" name="img_thb">
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="form-label">วันที่โอน</label>
                                                       <input type="text" name="transfer_date_thb" value="" class="form-control" />
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="form-label">เวลาที่โอน</label>
                                                       <div class="div_time form-control">
                                                            <select name="hours_thb" class="input_time">
                                                                 <option value>ชั่วโมง</option>
                                                                 @for ($i=1;$i<24;$i++)
                                                                      <option value="{{$i}}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                                 @endfor
                                                            </select>
                                                            <select name="minute_thb" class="input_time">
                                                                 <option value>นาที</option>
                                                                 @for ($i=1;$i<60;$i++)
                                                                      <option value="{{$i}}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                                 @endfor
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="form-label">โน็ต</label>
                                                       <textarea class="form-control" name="note_thb"></textarea>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-6 text-center">
                                        <div class="card">
                                             <div class="card-header">
                                                  <h5>เงินกีบ</h5>
                                             </div>
                                             <div class="card-body">
                                                  <div class="form-group">
                                                       <img id="preview_img_lak" src="{{asset('assets/images/product/prod-0.jpg')}}" alt="" style=" height: 250px; width: 250px;" />
                                                       <div class="mt-3">
                                                            <input type="file" onchange="readURL2(this);" class="btn-warning" name="image_lak">
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="form-label">วันที่โอน</label>
                                                       <input type="text" name="transfer_date_lak" value="" class="form-control" />
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="form-label">เวลาที่โอน</label>
                                                       <div class="div_time form-control">
                                                            <select name="hours_lak" class="input_time">
                                                                 <option value>ชั่วโมง</option>
                                                                 @for ($i=1;$i<24;$i++)
                                                                      <option value="{{$i}}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                                 @endfor
                                                            </select>
                                                            <select name="minutes_lak" class="input_time">
                                                                 <option value>นาที</option>
                                                                 @for ($i=1;$i<60;$i++)
                                                                      <option value="{{$i}}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                                 @endfor
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="form-group">
                                                       <label class="form-label">โน็ต</label>
                                                       <textarea class="form-control" name="note_lak"></textarea>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-12 text-center">
                                        <div class="card">
                                             <div class="card-header">
                                                  <h5>รายการขายที่สำเร็จแล้ว</h5>
                                             </div>
                                             <div class="card-body">
                                                  <div class="table-responsive">
                                                       <div class="dt-responsive table-responsive">
                                                            <table id="order_transfer_table" class="table table-striped table-bordered nowrap">
                                                                 <thead>
                                                                 </thead>
                                                                 <tbody>
                                                                 </tbody>
                                                                 <tfoot>
                                                                 </tfoot>
                                                            </table>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              {{-- <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                             <label class="form-label">วันที่โอน</label>
                                             <input type="text" name="transfer_date" value="" class="form-control" />
                                        </div>
                                   </div>
                                   <div class="col-md-6">
                                        <div class="form-group">
                                             <label class="form-label">เวลาที่โอน</label>
                                             <div class="div_time form-control">
                                                  <select name="hours" id="hours" class="input_time">
                                                       <option value>ชั่วโมง</option>
                                                       @for ($i=1;$i<24;$i++)
                                                            <option value="{{$i}}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                       @endfor
                                                  </select>
                                                  <select name="minutes" id="minutes" class="input_time">
                                                       <option value>นาที</option>
                                                       @for ($i=1;$i<60;$i++)
                                                            <option value="{{$i}}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                                       @endfor
                                                  </select>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="col-md-6">
                                        <div class="form-group">
                                             <label class="form-label">โน็ต</label>
                                             <textarea class="form-control" name="note"></textarea>
                                        </div>
                                   </div>
                              </div> --}}

                         </form>
                    </div>
                    <div class="modal-footer">
                         <button type="button" id="btn-upload" class="btn btn-primary"><i class="fa fa-save mr-2" aria-hidden="true"></i>โอนเงิน</button>
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

     <div class="modal fade modal-order-detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title h4" id="myLargeModalLabel">รายละเอียดของออเดอร์</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body order-info-area">

                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn  btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                    </div>
               </div>
          </div>
     </div>
@endsection
@section('js_bottom')
<!-- datatable Js -->
<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>
<!-- notification Js -->
<script src="{{asset('assets/js/plugins/bootstrap-notify.min.js')}}"></script>
<!-- datepicker js -->
<script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>
<script src="{{asset('assets/js/plugins/apexcharts.min.js')}}"></script>
<script>
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

     // setTimeout(function() {
     //      $('#shipping_table').DataTable({
     //           // "scrollY": "500px",
     //           "scrollCollapse": true,
     //           "paging": false
     //      });
     // });

     $.ajaxSetup({
         headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });

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
          order_arr = [];
          $(".order_chk_p").each(function(i, obj) {
               order_arr.push($(this).prop("checked"));
          });
          if(inArray(false, order_arr)){
               $(".order_chk_all_p").prop("checked", false);
          } else {
               $(".order_chk_all_p").prop("checked", true);
          }
     });

     $('body').on('click', '#transfer-ceo-btn', function (e) {
          e.preventDefault();
          order_arr = [];
          $(".order_chk_p").each(function(i, obj) {
               if ($(this).prop("checked") == true){
                    order_arr.push($(this).val());
               }
          });
          if (order_arr.length > 0) {
               $.ajax({
                    method : "post",
                    url : '{{ route('dashboard.getOrdersView') }}',
                    data : { "order_ids" : order_arr },
                    dataType : 'json',
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                         $("#order_transfer_table thead").empty();
                         $("#order_transfer_table tbody").empty();
                         $("#order_transfer_table tfoot").empty();
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    var html = '';
                    var th = '';
                    var tf = '';
                    if(rec.status==1){
                         th += '<tr>';
                         th += '<th class="text-center">No.</th>';
                         th += '<th class="text-left">Order No.</th>';
                         th += '<th class="text-center">เก็บเงินปลายทาง(THB)</th>';
                         th += '<th class="text-center">เก็บเงินปลายทาง(LAK)</th>';
                         th += '<th class="text-center">หมายเหตุ</th>';
                         th += '<th class="text-center">วันที่ได้รับเงิน</th>';
                         th += '<tr>';

                         $("#order_transfer_table thead").append(th);
                         var i = 1;
                         var txt = '';
                         var sum_bath = 0;
                         var sum_lak = 0;
                         $.each(rec.user_orders, function( index, user_order ) {
                              html += '<tr>';
                              html += '     <td class="text-center">'+ i +'</td>';
                              html += '     <td class="text-left"><input type="hidden" name="order_id[]" value="'+user_order.order.id+'">' + user_order.order.order_no + '</td>';
                              html += '     <td class="text-center">'+user_order.receive_money_thb+'</td>';
                              html += '     <td class="text-center">'+user_order.receive_money_lak+'</td>';
                              if (user_order.order.remark) {
                                   txt = user_order.order.remark;
                              }
                              html += '     <td class="text-center">'+txt+'</td>';
                              html += '     <td class="text-center">'+user_order.order.received_at+'</td>';
                              html += '</tr>';
                              i++;

                              sum_bath = sum_bath + user_order.receive_money_thb;
                              sum_lak = sum_lak + user_order.receive_money_lak;
                         });

                         tf += '<tr>';
                         tf += '<td colspan="2" class="text-right">จำนวนเงินที่โอน</td>';
                         tf += '<td class="text-center"><span class="text-primary mr-2">';
                         // <input type="hidden" name="sum_bath" value="'+sum_bath+'">'+addNumformat(sum_bath.toFixed(2))+'</span>THB
                         tf += '<input type="text" class="form-control" name="sum_bath" value="'+sum_bath+'">';
                         tf += '</td>';

                         tf += '<td class="text-center"><span class="text-primary mr-2">';
                         // <input type="hidden" name="sum_lak" value="'+sum_lak+'">'+addNumformat(sum_lak.toFixed(2))+'</span>LAK';
                         tf += '<input type="text" class="form-control" name="sum_lak" value="'+sum_lak+'">';
                         tf += '</td>';
                         tf += '</tr>';

                         $("#order_transfer_table tbody").append(html);
                         $("#order_transfer_table tfoot").append(tf);
                         // $('#order_transfer_table').DataTable();
                         $(function() {
                             $('input[name="transfer_date_thb"]').daterangepicker({
                                   singleDatePicker: true,
                                   showDropdowns: true,
                                   minYear: 2020,
                                   maxYear: parseInt(moment().format('YYYY'),10),
                                   locale: {
                                      format: 'DD MMM YYYY'
                                  }
                             });
                             $('input[name="transfer_date_lak"]').daterangepicker({
                                   singleDatePicker: true,
                                   showDropdowns: true,
                                   minYear: 2020,
                                   maxYear: parseInt(moment().format('YYYY'),10),
                                   locale: {
                                      format: 'DD MMM YYYY'
                                  }
                             });
                         });

                         $(".transfer-ceo-modal").modal("show");
                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
               });
          } else {
               notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
          }

     });

     $('body').on('click', '.shipping-detail-btn', function (e) {
          e.preventDefault();
          var shipping_id = $(this).data("id");
          $.ajax({
               method : "post",
               url : '{{ route('dashboard.getShippingsView') }}',
               data : { "shipping_id" : shipping_id },
               dataType : 'json',
               headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },
               beforeSend: function() {
                    $("#preloaders").css("display", "block");
                    $("#shipping_table thead").empty();
                    $("#shipping_table tbody").empty();
                    $("#shipping_table tfoot").empty();
               },
          }).done(function(rec){
               $("#preloaders").css("display", "none");
               var html = '';
               var th = '';
               if(rec.status==1){
                    $(".shipping_name").text(rec.shipping_name);
                    th += '<tr>';
                    th += '     <th style="width: 10%" class="border-top-0 text-center">No</th>';
                    th += '     <th style="width: 10%" class="border-top-0 text-center">วันที่สร้าง Order</th>';
                    th += '     <th style="width: 10%" class="border-top-0 text-center">ORDER NO.</th>';
                    th += '     <th style="width: 10%" class="border-top-0 text-center">ชื่อลูกค้า</th>';
                    th += '     <th style="width: 30%" class="border-top-0 text-center">ที่อยู่</th>';
                    th += '     <th style="width: 10%" class="border-top-0 text-center">ราคา</th>';
                    th += '</tr>';
                    $("#shipping_table thead").append(th);
                    var i = 1;
                    var txt = 0;
                    $.each(rec.orders, function( index, order ) {
                         html += '<tr>';
                         html += '<td>' + i + '</td>';
                         html += '<td>' + order.order_no + '</td>';
                         html += '<td>' + ConvertDateToThai(order.created_at) + '</td>';
                         html += '<td>' + order.customer_name + '</td>';
                         html += '<td>' + order.customer_address + " " + order.customer_city  + "<br/>" + order.laos_district.name + " " + order.customer_phone_number + '</td>';
                         if (order.cod_amount > 0){
                              txt = '<span class="badge badge-light-info badge-pill mr-1 mb-1">เก็บเงินปลายทาง : ' + order.cod_amount + " " + order.currency.name + '</span>';
                         }
                         html += '<td>' + txt + '</td>';
                         html += '</tr>';
                         i++;
                    });
                    $("#shipping_table tbody").append(html);
                    $('#shipping_table').DataTable();
                    $(".view-shipping-modal").modal("show");
               }
          }).fail(function(){
               $("#preloaders").css("display", "none");
               swal("", rec.content, "error");
          });
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
               var currency_name = '';
               if(rec.status==1){
                    $.each(rec.transfers, function( index, transfer ) {
                         html += '<tr>';
                         html += '<td>';
                         if (transfer.status == 'Y') {
                              html += '-';
                         } else {
                              html += '<input type="checkbox" class="transfer_chk" value="'+transfer.id+'">';
                         }
                         html += '</td>';
                         html += '<td>'+transfer.image+'</td>';
                         if (transfer.currency) {
                              currency_name = transfer.currency.name;
                         } else {
                              currency_name = '<span class="text-danger">ยังไม่ระบุสกุลเงิน</span>';
                         }
                         html += '<td>' + transfer.amount + ' ' + currency_name + '</td>';
                         html += '<td>'+transfer.transfer_date+'</td>';
                         if (transfer.transfer_hours && transfer.transfer_minutes){
                              html += '<td>'+ (transfer.transfer_hours.padStart(2, '0'))  + ":" + (transfer.transfer_minutes.padStart(2, '0')) +'</td>';
                         } else {
                              html += '<td>ไม่พบวันเวลาโอน</td>';
                         }
                         html += '<td>'+ ((transfer.remark) ? transfer.remark : '-') +'</td>';
                         html += '<td><span class="badge '+((transfer.status == 'Y') ? 'badge-light-success' : 'badge-light-warning')+'">'+ ((transfer.status == 'Y') ? 'ตรวจสอบแล้ว' : 'รอตรวจสอบ') +'</span></td>';
                         if (transfer.user){
                              html += '<td>'+transfer.user.name+' '+transfer.user.lastname+'</td>';
                         } else {
                              html += '<td>-</td>';
                         }
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
               $("#preloaders").css("display", "none");
               swal("", rec.content, "error");
          });
     });

     function readURL(input) {
         if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function (e) {
                    $('#preview_img_thb').attr('src', e.target.result);
               }
               reader.readAsDataURL(input.files[0]);
         }
     }
     function readURL2(input) {
         if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function (e) {
                    $('#preview_img_lak').attr('src', e.target.result);
               }
               reader.readAsDataURL(input.files[0]);
         }
     }

     $('body').on('click', '#btn-upload', function (e) {
          e.preventDefault();
          swal({
               title: 'คุณต้องการอัพโหลดหลักฐานการโอนใช่หรือไม่',
               icon: "warning",
               buttons: true,
               dangerMode: true,
          })
          .then((result) => {
               if (result == true){
                    var form = $('#FormAttachFile')[0];
                    var formData = new FormData(form);
                    $.ajax({
                         method : "POST",
                         url : '{{ route('dashboard.transfer') }}',
                         dataType : 'json',
                         data : formData,
                         processData: false,
                         contentType: false,
                    }).done(function(rec){
                         if (rec.status == 1) {
                              notify("top", "right", "feather icon-layers", "success", "", "", rec.content);
                              $(".transfer-ceo-modal").modal("hide");
                              location.reload();
                         } else {
                              notify("top", "right", "feather icon-layers", "danger", "", "", rec.content);
                         }
                    }).fail(function(){
                         notify("top", "right", "feather icon-layers", "danger", "", "", "Error");
                    });
               }
          });
     });

     $('body').on('click', '.btn-get-info', function (e) {
          e.preventDefault();
          var order_id = $(this).data('value');
          $.ajax({
               method : "post",
               url : '{{ route('order.info') }}',
               dataType : 'json',
               data: {"order_id" : order_id},
               beforeSend: function() {
                    $("#preloaders").css("display", "block");
                    $(".order-info-area").empty();
               },
          }).done(function(rec){
               $("#preloaders").css("display", "none");
               if (rec.status == 1) {
                    $(".order-info-area").html(rec.html);
                    $(".modal-order-detail").modal('show');
               }
          }).fail(function(){
               $("#preloaders").css("display", "none");
               notify("top", "right", "feather icon-layers", "danger", "", "", "Error");
          });
     });


     $(function() {
          var admin_value_arr = '{!! json_encode($admin_value_arr) !!}';
          if (admin_value_arr){
               var options = {
                    chart: {
                         height: 135,
                         type: 'donut',
                         sparkline: {
                              enabled: true
                         }
                    },
                    dataLabels: {
                         enabled: true
                    },
                    colors: ["#4099ff", "#0e9e4a", "#00bcd4", "#FFB64D", "#FF5370"],
                    series: admin_value_arr,
                    labels: {!! json_encode($admin_name_arr) !!},
                    grid: {
                         padding: {
                              top: 20,
                              right: 0,
                              bottom: 0,
                              left: 0
                         },
                    },
                    legend: {
                         show: false,
                         position: 'left',
                    }
               }
               var chart = new ApexCharts(
                    document.querySelector("#device-chart"),
                    options
               );
               chart.render()
          }

     });


</script>
@endsection
