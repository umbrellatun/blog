@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
         <div class="col-12">
             <div class="card">
                 <div class="card-header">
                    <h5>{{$titie}}</h5>
                 </div>
                 <div class="card-body">
                      <div class="row">
                           <div class="col-12">
                                <form action="" method="GET">
                                     <div class="form-group">
                                          <label>วันที่เอกสาร</label>
                                          <input type="text" name="daterange" autocomplete="off" class="form-control w-50" value="{{ isset($_GET["daterange"]) ? $_GET["daterange"] : $daterange }}" />
                                     </div>
                                     <div class="form-group">
                                          <input type="submit" class="btn btn-primary" value="Search">
                                     </div>
                                </form>
                           </div>
                      </div>
                      <div class="row">
                           <div class="col-12">
                                <div class="card bg-white">
                                     <div class="card-header">
                                          <h5>หลักฐานการโอนเงินจาก Admin</h5>
                                     </div>
                                     <div class="card-body">
                                          <div class="dt-responsive table-responsive">
                                               <table class="table nowrap">
                                                    <thead>
                                                        <tr class="border-bottom-info">
                                                             <th class="text-left">#</th>
                                                             <th class="text-left">รหัสการโอน</th>
                                                             <th class="text-center">โอนเล้ว(THB)</th>
                                                             <th class="text-center">โอนเล้ว(LAK)</th>
                                                             <th class="text-center">คนที่สร้างรายการ</th>
                                                             <th class="text-center">วันที่สร้างรายการ</th>
                                                             <th class="text-center">Action</th>
                                                        </tr>
                                                   </thead>
                                                   <tbody>
                                                        @php
                                                             $i = 1;
                                                        @endphp
                                                        @foreach ($user_order_transfers as $key => $user_order_transfer)
                                                             <tr>
                                                                  <td>{{$i}}</td>
                                                                  <td><a href="#" class="transfer_code text-primary" data-value="{{$user_order_transfer->id}}">#{{ str_pad($user_order_transfer->id, 5, '0', STR_PAD_LEFT) }}</a></td>
                                                                  <td class="text-right">{{ number_format($user_order_transfer->amount_thb) }}</td>
                                                                  <td class="text-right">{{ number_format($user_order_transfer->amount_lak) }}</td>
                                                                  <td class="text-center">{{$user_order_transfer->User->name}} {{$user_order_transfer->User->lastname}}</td>
                                                                  <td class="text-center">{{$user_order_transfer->created_at}}</td>
                                                                  <td class="text-center">
                                                                       <a href="#" class="btn waves-effect waves-light btn-info view-order-btn" data-id="{{$user_order_transfer->id}}" data-toggle="tooltip" title="ดู Order ที่เกี่ยวข้อง">
                                                                            <i class="fa fa-eye mr-2 "></i>ดูออเดอร์ที่เกี่ยวข้อง
                                                                       </a>
                                                                  </td>
                                                             </tr>
                                                             @php
                                                                  $i++;
                                                             @endphp
                                                        @endforeach
                                                   </tbody>
                                               </table>
                                          </div>
                                     </div>
                                </div>
                           </div>
                      </div>
                      <div class="row">
                           <div class="col-12">
                                @foreach ($companies as $company)
                                    <div class="card bg-white">
                                         <div class="card-header">
                                              <h5>{{$company->name}}</h5>
                                         </div>
                                         <div class="card-body">
                                              <div class="col-12">
                                                   <div class="row">
                                                        @foreach ($currencies as $currency)
                                                             <div class="col-6">
                                                                  <div class="card analytic-card {{$currency->bgcolor}}">
                                                                       <div class="card-body">
                                                                            <div class="row align-items-center m-b-25">
                                                                                 <div class="col-auto">
                                                                                      <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 50px;">
                                                                                 </div>
                                                                                 <div class="col text-right">
                                                                                      @php
                                                                                           $sum_thb = 0;
                                                                                           $sum_lak = 0;
                                                                                      @endphp
                                                                                      @foreach ($company->Order as $order)
                                                                                         @if ($order->currency_id == 1)
                                                                                              @if ($order->UserOrder)
                                                                                                   @php

                                                                                                       $sum_thb = $sum_thb + $order->UserOrder->receive_money_thb;
                                                                                                  @endphp
                                                                                              @endif
                                                                                         @endif
                                                                                         @if ($order->currency_id == 2)
                                                                                              @if ($order->UserOrder)
                                                                                                   @php
                                                                                                       $sum_lak = $sum_lak + $order->UserOrder->receive_money_lak;
                                                                                                  @endphp
                                                                                              @endif
                                                                                         @endif
                                                                                      @endforeach
                                                                                      <h3 class="m-b-5 text-white">{{ ($currency->id == 1 ? number_format($sum_thb) : number_format($sum_lak)) }}</h3>
                                                                                      <h6 class="m-b-0 text-white">{{ $currency->name }}</h6>
                                                                                 </div>
                                                                            </div>
                                                                            <h5 class="text-white d-inline-block m-b-0 m-l-10">{{$currency->name_th}}</h5>
                                                                            {{-- <p class="m-b-0 text-white d-inline-block">Total Revenue : </p> --}}
                                                                            {{-- <i class="fas fa-caret-up m-r-10 f-18"></i> --}}
                                                                            <h6 class="m-b-0 d-inline-block text-white float-right">ยอดเก็บเงินปลายทาง</h6>
                                                                       </div>
                                                                  </div>
                                                             </div>
                                                        @endforeach
                                                   </div>
                                                   <div class="card">
                                                         <div class="card-body">
                                                              <div class="row">
                                                                   <a href="#" class="btn waves-effect waves-light btn-primary mr-2 transfer-ceo-btn" id="transfer-ceo-btn{{$company->id}}" data-company="{{$company->id}}" data-toggle="tooltip" title="" data-original-title="โอนเงินให้ Partner">
                                                                        โอนเงินให้ Partner
                                                                   </a>
                                                              </div>
                                                              <div class="dt-responsive table-responsive">
                                                                   <table class="table nowrap">
                                                                        {{-- cod-list-table  --}}
                                                                        <thead>
                                                                            <tr class="border-bottom-info">
                                                                                 <th class="text-left"><input type="checkbox" class="order_chk_all order_chk_all_{{$company->id}}" data-value="{{$company->id}}"></th>
                                                                                 <th class="text-left">Order NO.</th>
                                                                                 <th class="text-left">วันที่สร้าง Order</th>
                                                                                 <th class="text-center">โอนเล้ว(THB)</th>
                                                                                 <th class="text-center">โอนเล้ว(LAK)</th>
                                                                                 <th class="text-center">เก็บเงินปลายทาง (THB)</th>
                                                                                 <th class="text-center">เก็บเงินปลายทาง (LAK)</th>
                                                                                 <th class="text-center">วันเวลาที่โอนเงิน</th>
                                                                                 <th class="text-center">โอนเงินโดย</th>
                                                                                 <th class="text-center">หมายเหตุ</th>
                                                                                 <th class="text-center">รหัสการโอน</th>
                                                                            </tr>
                                                                       </thead>
                                                                       <tbody>
                                                                            @php
                                                                                 $i = 1;
                                                                            @endphp
                                                                            @foreach ($company->Order as $order)
                                                                                 @if (isset($order->UserOrder))
                                                                                      @php
                                                                                           $amount_thb = 0;
                                                                                           $amount_lak = 0;
                                                                                      @endphp
                                                                                      @if ($order->Transfer)
                                                                                           @foreach ($order->Transfer as $key => $Transfer)
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
                                                                                           <td class="text-center">
                                                                                                <div class="form-group">
                                                                                                     <div class="form-check">
                                                                                                          <input type="checkbox" class="order_chk order_chk_{{$company->id}} form-check-input" data-value="{{$company->id}}" value="{{$order->id}}">
                                                                                                     </div>
                                                                                                </div>
                                                                                           </td>
                                                                                           <td class="text-left">{{$order->order_no}}</td>
                                                                                           <td class="text-left">{{$order->created_at}}</td>
                                                                                           <td class="text-right">{{ number_format($amount_thb) }}</td>
                                                                                           <td class="text-right">{{ number_format($amount_lak) }}</td>
                                                                                           <td class="text-right">{{ number_format($order->UserOrder->receive_money_thb) }}</td>
                                                                                           <td class="text-right">{{ number_format($order->UserOrder->receive_money_lak) }}</td>
                                                                                           <td class="text-center">{{$order->UserOrder->transfer_date}}</td>
                                                                                           <td class="text-center">{{$order->UserOrder->TransferBy->name}} {{$order->UserOrder->TransferBy->lastname}}</td>
                                                                                           <td class="text-center">{{ isset($order->UserOrder->remark) ? $order->UserOrder->remark : '-' }}</td>
                                                                                           <td class="text-center"><a href="#" class="transfer_code text-primary" data-value="{{$order->UserOrder->user_order_transfer_id}}">#{{ str_pad($order->UserOrder->user_order_transfer_id, 5, '0', STR_PAD_LEFT) }}</a></td>
                                                                                      </tr>
                                                                                 @endif
                                                                            @endforeach
                                                                       </tbody>
                                                                   </table>
                                                              </div>
                                                         </div>
                                                    </div>
                                              </div>
                                         </div>
                                    </div>
                               @endforeach
                           </div>
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
                                             <th>รหัสการโอน</th>
                                             <th>ชื่อไฟล์</th>
                                             <th>จำนวนเงิน(THB)</th>
                                             <th>จำนวนเงิน(LAK)</th>
                                             <th>วันที่โอน</th>
                                             <th>เวลาโอน</th>
                                             <th>หมายเหตุ</th>
                                             <th>ผู้โอน</th>
                                             <th>action</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                              </table>
                         </div>
                    </div>
                    <div class="modal-footer">
                         {{-- <button type="button" class="btn btn-primary btn-check-transfer"><i class="fa fa-check mr-2" aria-hidden="true"></i>ตรวจสอบแล้ว</button> --}}
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

     <div class="modal fade transfer-ceo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
                {{-- modal-xl --}}
               <div class="modal-content" style="width:1480px !important; margin-left: -100px;">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel">โอนเงินให้ Partner</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <form id="FormAttachFile">
                              <div class="row">
                                   <div class="col-4 text-center">
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
                                   <div class="col-8 text-center">
                                        <div class="row">
                                             <div class="col-12 text-center">
                                                  <div class="card">
                                                       <div class="card-header">
                                                            <h5 class="text-success">รายการขายที่สำเร็จแล้ว</h5>
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
                                        {{-- <div class="card">
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
                                        </div> --}}
                                   </div>
                              </div>

                         </form>
                    </div>
                    <div class="modal-footer">
                         <button type="button" id="btn-upload" class="btn btn-primary"><i class="fa fa-save mr-2" aria-hidden="true"></i>โอนเงิน</button>
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                    </div>
               </div>
          </div>
     </div>

     <div class="modal fade view-all_order-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLiveLabel">ออเดอร์ที่เกี่ยวข้อง</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <div class="table-responsive">
                              <table class="table" id="all_order_table">
                                   <thead>
                                        <tr>
                                             <th class="text-center">#</th>
                                             <th class="text-left">Order NO.</th>
                                             <th class="text-left">วันที่สร้าง Order</th>
                                             <th class="text-center">โอนเล้ว(THB)</th>
                                             <th class="text-center">โอนเล้ว(LAK)</th>
                                             <th class="text-center">เก็บเงินปลายทาง (THB)</th>
                                             <th class="text-center">เก็บเงินปลายทาง (LAK)</th>
                                             <th class="text-center">วันเวลาที่โอนเงินให้ CEO</th>
                                             <th class="text-center">โอนเงินโดย</th>
                                             <th class="text-center">หมายเหตุ</th>
                                             <th class="text-center">หลักฐานการโอน</th>
                                             <th class="text-center">รหัสการโอน</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                              </table>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
                    </div>
               </div>
          </div>
     </div>

     <div class="modal fade view-transfer-slip-modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
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
                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2" aria-hidden="true"></i>ปิด</button>
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
     <!-- daterangepicker -->
     <script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>
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

     $('.cod-list-table').DataTable();
     $('#transfer-list-table').DataTable();
     $(function() {
          $('input[name="daterange"]').daterangepicker({
               locale: {
                    format: 'DD MMM YYYY'
               },
               opens: 'left'
          }, function(start, end, label) {

          });

          $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
               $(this).val('');
          });

     });

     $(document).ready(function() {
          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });


          $('body').on('click', '.transfer_code', function (e) {
               e.preventDefault();
               var user_order_transfer_id = $(this).data("value");
               $.ajax({
                    method : "post",
                    url : '{{ route('finance.getTranfersView') }}',
                    data : { "user_order_transfer_id" : user_order_transfer_id },
                    dataType : 'json',
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                         $("#transfer_table tbody").empty();
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    var html = '';
                    var i = 1;
                    var currency_name = '';
                    if(rec){
                         $.each(rec, function( index, detail ) {
                              html += '<tr>';
                              html += '<td>'+i+'</td>';
                              html += '<td><span class="text-primary">#'+ (detail.user_order_transfer_id).toString().padStart(5,'0') +'</span></td>';
                              html += '<td>'+detail.image+'</td>';
                              if (detail.currency_id == 1) {
                                   html += '<td class="text-right">'+ addNumformat(detail.amount)+'</td>';
                                   html += '<td class="text-right"></td>';
                              } else {
                                   html += '<td class="text-right"></td>';
                                   html += '<td class="text-right">'+ addNumformat(detail.amount)+'</td>';
                              }
                              html += '<td>'+detail.transfer_date+'</td>';
                              // html += '<td>' + (detail.transfer_hours).toString().padStart(2,'0') + ":" + (detail.transfer_minutes).toString().padStart(2,'0') + '</td>';
                              html += '<td>-</td>';
                              if (detail.remark){
                                   html += '<td>'+ detail.remark +'</td>';
                              } else {
                                   html += '<td>-</td>';
                              }
                              html += '<td>'+detail.user.name + ' ' + detail.user.lastname+'</td>';
                              html += '<td>';
                              html += '<a href="#" class="btn btn-success btn-view" data-toggle="modal" data-value="'+detail.id+'" title="ดูหลักฐานการโอน">';
                              html += '<i class="fa fa-eye mr-2"></i>สลิปที่ Admin โอนให้ CEO';
                              html += '</a>';
                              html += '</td>';
                              html += '</tr>';

                              i = i+1;
                         });
                         $("#transfer_table tbody").append(html);
                         $(".view-transfer-slip-modal").modal("show");
                    } else {

                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    // swal("", rec.content, "error");
               });
          });

          $('body').on('click','.btn-view',function(e){
               e.preventDefault();
               $.ajax({
                    method : "POST",
                    url : '{{ route('finance.getimage') }}',
                    dataType : 'json',
                    data : {"data" : $(this).data("value")},
               }).done(function(rec){
                    $("#transfer_slip_img").attr("src", '{{asset('')}}' + '/' + rec.image);
                    $("#exampleModalLive").modal('show');
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });
          });

          $('body').on('change', '.order_chk_all', function (e) {
               e.preventDefault();
               var data_value = $(this).data("value");

               if ($(this).prop("checked") == true) {
                    $(".order_chk_" + data_value).prop("checked", true);
               } else {
                    $(".order_chk_" + data_value).prop("checked", false);
               }
          });

          $('body').on('change', '.order_chk', function (e) {
               e.preventDefault();
               var data_value = $(this).data("value");
               order_arr = [];
               $(".order_chk_" + data_value).each(function(i, obj) {
                    order_arr.push($(this).prop("checked"));
               });
               if(inArray(false, order_arr)){
                    $(".order_chk_all_" + data_value).prop("checked", false);
               } else {
                    $(".order_chk_all_" + data_value).prop("checked", true);
               }
          });

          $('body').on('click', '.transfer-ceo-btn', function (e) {
               e.preventDefault();
               var company_id = $(this).data("company");
               order_check_arr = [];
               $(".order_chk_"+ company_id).each(function(i, obj) {
                    if ($(this).prop("checked") == true){
                         order_check_arr.push($(this).data("value"));
                    }
               });
               if (order_check_arr[0] == company_id){
                    order_arr = [];
                    $(".order_chk").each(function(i, obj) {
                         if ($(this).prop("checked") == true){
                              order_arr.push($(this).val());
                         }
                    });
                    if (order_arr.length > 0) {
                         $.ajax({
                              method : "post",
                              url : '{{ route('finance.getOrdersView') }}',
                              data : { "order_ids" : order_arr , "company_id" : company_id},
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
                                   th += '<th class="text-left">Order NO.</th>';
                                   th += '<th class="text-left">วันที่สร้าง Order</th>';
                                   th += '<th class="text-center">ค่าสินค้า (THB)</th>';
                                   th += '<th class="text-center">ค่าสินค้า (LAK)</th>';
                                   th += '<th class="text-center">ค่ากล่อง (THB)</th>';
                                   th += '<th class="text-center">ค่ากล่อง (LAK)</th>';
                                   th += '<th class="text-center">ค่าขนส่ง (THB)</th>';
                                   th += '<th class="text-center">ค่าขนส่ง (LAK)</th>';
                                   th += '<th class="text-center">ค่าหยิบ/แพ็ค (THB)</th>';
                                   th += '<th class="text-center">ค่าหยิบ/แพ็ค (LAK)</th>';
                                   th += '<th class="text-center">ค่า COD (THB)</th>';
                                   th += '<th class="text-center">ค่า COD (LAK)</th>';
                                   th += '<th class="text-center">รวม(THB)</th>';
                                   th += '<th class="text-center">รวม(LAK)</th>';
                                   th += '<tr>';

                                   $("#order_transfer_table thead").append(th);
                                   var i = 1;
                                   var percent_cod = 0;
                                   var order_amount_thb = 0;
                                   var order_amount_lak = 0;
                                   var sum_thb = 0;
                                   var sum_lak = 0;
                                   $.each(rec.user_orders, function( index, user_order ) {
                                        html += '<tr>';
                                        html += '     <td class="text-center">'+ i +'</td>';
                                        html += '     <td class="text-left"><input type="hidden" name="order_id[]" value="'+user_order.order.id+'">' + user_order.order.order_no + '</td>';
                                        html += '     <td class="text-center">'+user_order.order.created_at+'</td>';

                                        var product_amount_thb = 0;
                                        var product_amount_lak = 0;
                                        var box_amount_thb = 0;
                                        var box_amount_lak = 0;
                                        $.each(user_order.order.order_product, function( index2, order_product ) {
                                             if (user_order.order.currency_id == 1) {
                                                  product_amount_thb = product_amount_thb + order_product.price_bath;
                                             }
                                             if (user_order.order.currency_id == 2) {
                                                  product_amount_lak = product_amount_lak + order_product.price_lak;
                                             }
                                        });
                                        html += '     <td class="text-right">'+ addNumformat(product_amount_thb) +'</td>';
                                        html += '     <td class="text-right">'+ addNumformat(product_amount_lak) +'</td>';

                                        $.each(user_order.order.order_boxs, function( index2, order_box ) {
                                             if (user_order.order.currency_id == 1) {
                                                  box_amount_thb = box_amount_thb + order_box.price_bath;
                                             }
                                             if (user_order.order.currency_id == 2) {
                                                  box_amount_lak = box_amount_lak + order_box.price_lak;
                                             }
                                        });
                                        html += '     <td class="text-right">'+ addNumformat(box_amount_thb) +'</td>';
                                        html += '     <td class="text-right">'+ addNumformat(box_amount_lak) +'</td>';

                                        percent_cod = ((parseFloat(rec.company.delivery) * user_order.order.cod_amount) / 100);
                                        if (user_order.order.currency_id == 1) {
                                             html += '     <td class="text-right">'+user_order.order.shipping_cost+'</td>';
                                             html += '     <td class="text-center">-</td>';
                                             html += '     <td class="text-right">'+user_order.order.pack+'</td>';
                                             html += '     <td class="text-center">-</td>';
                                             html += '     <td class="text-right">' + percent_cod + '</td>';
                                             html += '     <td class="text-center">-</td>';

                                             // order_amount_thb = (product_amount_thb - box_amount_thb - user_order.order.shipping_cost) - (user_order.order.pack + percent_cod);
                                             order_amount_thb = (product_amount_thb + user_order.order.shipping_cost + box_amount_thb) - box_amount_thb - user_order.order.pack - percent_cod;
                                             sum_thb = sum_thb + order_amount_thb;

                                             html += '     <td class="text-right">' + addNumformat(order_amount_thb) + '</td>';
                                             html += '     <td class="text-center">-</td>';
                                        } else {
                                             html += '     <td class="text-center">-</td>';
                                             html += '     <td class="text-right">'+ addNumformat(user_order.order.shipping_cost) +'</td>';
                                             html += '     <td class="text-center">-</td>';
                                             html += '     <td class="text-right">' + addNumformat(parseFloat(user_order.order.pack) * parseFloat(rec.exchange_rate)) +'</td>';
                                             html += '     <td class="text-center">-</td>';
                                             html += '     <td class="text-right">' + addNumformat(percent_cod) + '</td>';

                                             order_amount_lak = (product_amount_lak + user_order.order.shipping_cost + box_amount_lak) - (box_amount_lak + (parseFloat(user_order.order.pack) * parseFloat(rec.exchange_rate)) + percent_cod);
                                             sum_lak = sum_lak + order_amount_lak;


                                             html += '     <td class="text-center">-</td>';
                                             html += '     <td class="text-right">' + addNumformat(order_amount_lak) + '</td>';
                                        }

                                        html += '</tr>';
                                        i++;
                                   });

                                   tf += '<tr>';
                                   tf += '<td colspan="13" class="text-right">จำนวนเงินที่โอน</td>';
                                   tf += '<td class="text-right">';
                                   tf += addNumformat(sum_thb);
                                   tf += '<input type="hidden" name="sum_thb" value="'+addNumformat(sum_thb)+'">';
                                   // tf += '<input type="text" name="sum_lak" value="'+sum_thb+'">';
                                   tf += '</td>';
                                   tf += '<td class="text-right">';
                                   tf += addNumformat(sum_lak);
                                   tf += '<input type="hidden" name="sum_lak" value="'+addNumformat(sum_lak)+'">';
                                   tf += '<input type="hidden" name="company_id" value="'+company_id+'">';
                                   // tf += '<input type="text" class="form-control" name="sum_lak" value="'+sum_lak+'">';
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
                              } else {
                                   notify("top", "right", "feather icon-layers", "danger", "", "", rec.content);
                              }
                         }).fail(function(){
                              $("#preloaders").css("display", "none");
                         });
                    } else {
                         notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
                    }
               } else {
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกอย่างน้อย 1 รายการ");
               }
          });

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
                              url : '{{ route('finance.transfer') }}',
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

          $('body').on('click', '.view-order-btn', function (e) {
               e.preventDefault();
               var user_order_transfer_id = $(this).data("id");
               $.ajax({
                    method : "post",
                    url : '{{ route('finance.getOrderView') }}',
                    data : { "user_order_transfer_id" : user_order_transfer_id },
                    dataType : 'json',
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                         $("#all_order_table tbody").empty();
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    var html = '';
                    var i = 1;
                    var amount_thb = 0;
                    var amount_lak = 0;
                    var remark = '';
                    if(rec.status==1){
                         $.each(rec.user_order_transfer.user_order, function( index, user_order ) {
                              if (user_order.order.transfer) {
                                   $.each(user_order.order.transfer, function( index2, transfer ) {
                                        if (transfer.currency_id == 1) {
                                             amount_thb = parseInt(amount_thb) + parseInt(transfer.amount);
                                        }
                                        if (transfer.currency_id == 2) {
                                             amount_lak = parseInt(amount_lak) + parseInt(transfer.amount);
                                        }
                                   });
                              }

                              html += '<tr>';
                              html += '<td>'+i+'</td>';
                              html += '<td>'+user_order.order.order_no+'</td>';
                              html += '<td>'+user_order.order.created_at+'</td>';
                              html += '<td class="text-right">'+amount_thb+'</td>';
                              html += '<td class="text-right">'+amount_lak+'</td>';
                              html += '<td class="text-right">'+addNumformat(user_order.receive_money_thb)+'</td>';
                              html += '<td class="text-right">'+addNumformat(user_order.receive_money_lak)+'</td>';
                              html += '<td class="text-right">'+user_order.transfer_date+'</td>';
                              html += '<td class="text-right">'+user_order.transfer_by.name + ' ' + user_order.transfer_by.lastname +'</td>';
                              if (user_order.remark){
                                   remark = user_order.remark;
                              } else {
                                   remark = '-';
                              }

                              html += '<td class="text-center">'+ remark +'</td>';


                              html += '<td class="text-center">';
                              if (user_order.order.transfer.length > 0){
                                   html += '<div class="overlay-edit" style="opacity: 1; background: none;">';
                                   html += '<a href="#" class="btn waves-effect waves-light btn-info view-transfer-slip-btn" data-id="'+user_order.order_id+'" data-toggle="tooltip" title="ดูหลักฐานการโอนทั้งหมด">';
                                   html += '<i class="fa fa-eye mr-2"></i>สลิปที่แนบมากับออเดอร์';
                                   html += '</a>';
                                   html += '</div>';
                              } else {
                                   html += '-';
                              }
                              html += '</td>';
                              html += '<td class="text-center">';
                              html += '<span class="text-primary">#'+user_order.user_order_transfer_id.toString().padStart(5,'0') +'</span>';
                              html += '</td>';
                              html += '</tr>';

                              i++;
                         });
                         $("#all_order_table tbody").append(html);
                         $(".view-all_order-modal").modal("show");
                    } else {

                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });
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
                    $(".view-transfer-slip-modal2").modal("show");
                    $(".btn-check-transfer").attr('data-value', order_id);
               } else {

               }
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
     </script>
@endsection
