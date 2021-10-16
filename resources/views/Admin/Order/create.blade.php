@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
@section('css_bottom')
     <style>
     .div_time {

     }

     .input_time {
          background-color: #343a40;
          border: none;
          color: #adb7be;
          text-align: center;
          width: 100px;
          height: 25px;
     }
     </style>
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
                                             <h5 class="m-b-10">{{$titie}} {{$order_no}}</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                             <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                                             <li class="breadcrumb-item"><a href="{{route('order')}}">รายการสั่งซื้อ</a></li>
                                             <li class="breadcrumb-item">{{$titie}} {{$order_no}}</li>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <form id="FormAdd">
                         <div class="row">
                              <div class="col-md-4">
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>รายการสั่งซื้อ</h5>
                                             <span class="d-block m-t-5"></span>
                                             <hr style="border-top: 1px solid #999;"/>
                                        </div>
                                        <div class="card-body">
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="form-label">Order no.</label>
                                                       <input type="text" class="form-control" name="order_no" value="{{$order_no}}" readonly>
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="form-label">สกุลเงิน</label>
                                                       <select class="form-control" name="currency_id" id="currency_id">
                                                            <option value>กรุณาเลือก</option>
                                                            @foreach ($currencies as $currency)
                                                                 <option value="{{$currency->id}}" data-value="{{$currency->variable}}">{{$currency->name}}</option>
                                                            @endforeach
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="form-label">บริษัท</label>
                                                       <select class="form-control" name="company_id" id="company_id">
                                                            <option value>กรุณาเลือก</option>
                                                            @foreach ($companies as $company)
                                                                 <option value="{{$company->id}}">{{$company->name}}</option>
                                                            @endforeach
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="form-label">ส่วนลด</label>
                                                       <input type="text" class="form-control number-only" name="discount" id="discount" value="" >
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="form-label">โน็ต</label>
                                                       <textarea class="form-control" name="note" id="note"></textarea>
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <label class="form-label h4 text-danger">ยอดเรียกเก็บเงินปลายทาง (COD)<sup class="text-danger text-bold">*</sup></label>
                                                  <div class="form-group">
                                                       <input type="text" name="transfer_cod_amount" id="transfer_cod_amount" value="" class="form-control number-only" />
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-md-8">
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>ข้อมูลลูกค้า</h5>
                                             <span class="d-block m-t-5"></span>
                                             <hr style="border-top: 1px solid #999;"/>
                                        </div>
                                        <div class="card-body">
                                             <div class="row">
                                                  <div class="col-md-12">
                                                       <label class="form-label">ลูกค้า</label>
                                                       <div class="form-group">
                                                            <select class="js-example-basic-single form-control" name="customer_id" id="customer_id">
                                                                 <option value>กรุณาเลือก</option>
                                                                 @foreach ($customers as $customer)
                                                                      <option value="{{$customer->id}}">{{$customer->name}}</option>
                                                                 @endforeach
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <label class="form-label">ชื่อ - นามสกุล</label>
                                                       <div class="form-group">
                                                            <input type="text" class="form-control" name="customer_name" id="customer_name" value="" >
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <label class="form-label">ที่อยู่ในการจัดส่ง</label>
                                                       <div class="form-group">
                                                            <textarea class="form-control" name="customer_address" id="customer_address"></textarea>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <label class="form-label">เมือง</label>
                                                       <div class="form-group">
                                                            <input type="text" class="form-control" name="customer_city" id="customer_city" value="" >
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <label class="form-label">แขวง</label>
                                                       <div class="form-group">
                                                            <select class="js-example-basic-single form-control" name="laos_distict_id" id="laos_distict_id">
                                                                 <option value>กรุณาเลือก</option>
                                                                 @foreach ($laos_districts as $laos_district)
                                                                      <option value="{{$laos_district->id}}">{{$laos_district->name}}</option>
                                                                 @endforeach
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <label class="form-label">เบอร์โทรศัพท์</label>
                                                       <div class="form-group">
                                                            <input type="text" class="form-control number-only" name="customer_phone" id="customer_phone" value="" >
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="card-header">
                                             <h5>วิธีการจัดส่ง</h5>
                                             <span class="d-block m-t-5"></span>
                                             <hr style="border-top: 1px solid #999;"/>
                                        </div>
                                        <div class="card-body">
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <label class="form-label">วิธีการจัดส่ง</label>
                                                       <div class="form-group">
                                                            <select class="js-example-basic-single form-control" name="shipping_id" id="shipping_id">
                                                                 <option value>กรุณาเลือก</option>
                                                                 @foreach ($shippings as $shipping)
                                                                      <option value="{{$shipping->id}}">{{$shipping->name}}</option>
                                                                 @endforeach
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <label class="form-label">ค่าจัดส่ง</label>
                                                       <div class="form-group">
                                                            <input type="text" class="form-control number-only" name="shipping_cost" id="shipping_cost" value="0" >
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                   </div>
                              </div>

                              <div class="col-lg-4 col-md-12">
                                  <div class="card">
                                      <div class="card-header">
                                          <h5>อัพโหลดหลักฐานการโอน</h5>
                                          <span class="d-block m-t-5"></span>
                                          <hr style="border-top: 1px solid #999;"/><div class="card-header-right">
                                              <div class="btn-group card-option">
                                                  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="feather icon-more-horizontal"></i>
                                                  </button>
                                                  <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                      {{-- <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li> --}}
                                                      <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                                      {{-- <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li> --}}
                                                      {{-- <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li> --}}
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body">
                                           <div class="row">
                                                <div class="col-md-12 text-center">
                                                     <div class="form-group">
                                                          <img id="preview_img" src="{{asset('assets/images/product/prod-0.jpg')}}" alt="" style=" height: 160px; " />
                                                          <div class="mt-3">
                                                               <input type="file" onchange="readURL(this);" class="btn-warning" name="image" id="image">
                                                          </div>
                                                     </div>
                                                </div>
                                                <div class="col-md-12">
                                                     <label class="form-label">ยอดที่โอน</label>
                                                     <div class="form-group">
                                                        <input type="text" class="form-control number-only" name="transfer_price" id="transfer_price" value="" autocomplete="off" >
                                                   </div>
                                                </div>
                                                <div class="col-md-12">
                                                     <label class="form-label">สกุลเงิน</label>
                                                     <div class="form-group">
                                                          <select class="form-control" name="transfer_currency_id" id="transfer_currency_id">
                                                               <option value>กรุณาเลือก</option>
                                                               @foreach ($currencies as $currency)
                                                                    <option value="{{$currency->id}}">{{$currency->name}}</option>
                                                               @endforeach
                                                          </select>
                                                     </div>
                                                </div>
                                                <div class="col-md-5">
                                                     <label class="form-label">วันที่โอน</label>
                                                     <div class="form-group">
                                                          <input type="text" name="transfer_date" id="transfer_date" value="" class="form-control" />
                                                     </div>
                                                </div>
                                                <div class="col-md-7">
                                                     <label class="form-label">เวลาที่โอน</label>
                                                     <div class="form-group div_time">
                                                          {{-- <div class="">

                                                          </div> --}}
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

                                                <div class="col-md-12">
                                                     <label class="form-label">โน็ต</label>
                                                     <div class="form-group">
                                                          <textarea class="form-control" name="transfer_note"></textarea>
                                                     </div>
                                                </div>
                                           </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-8 col-md-12">
                                  <div class="card">
                                      <div class="card-header">
                                          <h5><i class="fas fa-box-open mr-2"></i>ใช้กล่องของเรา</h5>
                                          <span class="d-block m-t-5"></span>
                                          <hr style="border-top: 1px solid #999;"/><div class="card-header-right">
                                              <div class="btn-group card-option">
                                                  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="feather icon-more-horizontal"></i>
                                                  </button>
                                                  <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                      {{-- <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li> --}}
                                                      <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                                      {{-- <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li> --}}
                                                      {{-- <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li> --}}
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body">
                                           <div class="dt-responsive table-responsive">
                                                <table id="scr-vrt-dt2" class="table table-striped table-bordered nowrap">
                                                     <thead>
                                                          <tr>
                                                               <th class="border-top-0">ภาพ</th>
                                                               <th class="border-top-0">กล่อง</th>
                                                               {{-- @foreach ($currencies as $currency)
                                                                    <th class="border-top-0 price_bath">{{$currency->name_th}}</th>
                                                               @endforeach --}}
                                                               <th class="border-top-0 price_bath">ราคาขาย(บาท)</th>
                                                               <th class="border-top-0 price_lak">ราคาขาย(กีบ)</th>
                                                               {{-- <th class="border-top-0 price_usd">ราคาขาย(ดอลลาร์สหรัฐ)</th>
                                                               <th class="border-top-0 price_khr">ราคาขาย(เรียลกัมพูชา)</th> --}}
                                                               <th class="border-top-0">จำนวนคงเหลือในโกดัง</th>
                                                               <th class="border-top-0">action</th>
                                                          </tr>
                                                     </thead>
                                                     <tbody>
                                                          @foreach ($boxs as $key2 => $box)
                                                               <tr>
                                                                    <td>
                                                                        <div class="d-inline-block align-middle">
                                                                             <img src="{{asset('assets/images/product/'.$box->image)}}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$box->size}} <br/> {{$box->description}}</td>
                                                                    <td class="price_bath">{{ isset($box->price_bath) ? $box->price_bath : 0 }}</td>
                                                                    <td class="price_lak">{{ isset($box->price_lak) ? $box->price_lak : 0 }}</td>
                                                                    {{-- <td class="price_usd">{{ isset($box->price_usd) ? $box->price_usd : 0 }}</td>
                                                                    <td class="price_khr">{{ isset($box->price_khr) ? $box->price_khr : 0 }}</td> --}}
                                                                    <td>{{$box->in_stock}}</td>
                                                                    <td>
                                                                        <div class="btn-group w-25" role="group" aria-label="Basic example">
                                                                             <button type="button" class="btn btn-danger btn-number2 btn-sm number-only" data-type="minus" data-field="quant_box[{{$key2}}]">
                                                                                  <span class="fas fa-minus-circle"></span>
                                                                             </button>
                                                                             <button type="button" class="btn btn-success btn-number2 btn-sm number-only" data-type="plus" data-field="quant_box[{{$key2}}]">
                                                                                  <span class="fas fa-cart-plus"></span>
                                                                             </button>
                                                                        </div>
                                                                        <div class="form-group">
                                                                             <input type="text" name="quant_box[{{$key2}}]" id="box_id_{{$box->id}}" class="form-control input-number2 number-only w-75" value="0" min="0" max="{{$box->in_stock}}" data-value="{{$box->id}}">
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

                              <div class="col-md-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h5><i class="fas fa-warehouse mr-2"></i>สินค้าในโกดัง</h5>
                                             <span class="d-block m-t-5"></span>
                                             <hr style="border-top: 1px solid #999;"/>
                                        </div>
                                        <div class="card-body">
                                             <div class="dt-responsive table-responsive">
                                                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                                                       <thead>
                                                            <tr>
                                                                 <th class="border-top-0">ภาพ</th>
                                                                 <th class="border-top-0">SKU / ชื่อ</th>
                                                                 {{-- @foreach ($currencies as $currency)
                                                                      <th class="border-top-0 price_bath">{{$currency->name_th}}</th>
                                                                 @endforeach --}}
                                                                 <th class="text-center border-top-0 price_bath">ราคาขาย<br/>(บาท)</th>
                                                                 <th class="text-center border-top-0 price_lak">ราคาขาย<br/>(กีบ)</th>
                                                                 {{-- <th class="text-center border-top-0 price_usd">ราคาขาย<br/>(ดอลลาร์สหรัฐ)</th>
                                                                 <th class="text-center border-top-0 price_khr">ราคาขาย<br/>(เรียลกัมพูชา)</th> --}}
                                                                 <th class="text-center border-top-0">ประเภท</th>
                                                                 <th class="text-center border-top-0">จำนวนคงเหลือในโกดัง</th>
                                                                 <th class="text-center border-top-0">action</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            {{-- @foreach ($products as $key => $product)
                                                                 <tr>
                                                                      <td>
                                                                           <div class="d-inline-block align-middle">
                                                                                <img src="{{ isset($product->image) ? asset('uploads/products/'.$product->image) : asset('assets/images/product/prod-0.jpg')}}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
                                                                           </div>
                                                                      </td>
                                                                      <td>{{$product->sku}} <br/> {{$product->name}}</td>
                                                                      <td class="text-right">{{ number_format($product->price_bath, 2) }}</td>
                                                                      <td class="text-right">{{ number_format($product->price_lak, 2) }}</td>
                                                                      <td class="text-right">{{$product->ProductType->name}}</td>
                                                                      <td class="text-right">{{ isset($product->in_stock) ? $product->in_stock : 0 }}</td>
                                                                      <td>
                                                                           <div class="btn-group w-75" role="group" aria-label="Basic example">
                                                                                <button type="button" class="btn btn-danger btn-number btn-sm" data-type="minus" data-field="quant[{{$key}}]" title="หยิบออกจากรถเข็น">
                                                                                     <span class="fas fa-minus-circle"></span>
                                                                                </button>
                                                                                <button type="button" class="btn btn-success btn-number btn-sm" data-type="plus" data-field="quant[{{$key}}]" title="หยิบใส่รถเข็น">
                                                                                     <span class="fas fa-cart-plus"></span>
                                                                                </button>
                                                                           </div>
                                                                           <div class="form-group">
                                                                                <input type="text" name="quant[{{$key}}]" id="product_id_{{$product->id}}" class="w-75 input-number number-only form-control" value="0" min="0" max="{{$product->in_stock}}" data-value="{{$product->id}}">
                                                                           </div>
                                                                      </td>
                                                                 </tr>
                                                            @endforeach --}}
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-lg-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h5><i class="fas fa-shopping-cart mr-2"></i>ตระกร้าสินค้า</h5>
                                             <span class="d-block m-t-5"></span>
                                             <hr style="border-top: 1px solid #999;"/>
                                        </div>
                                        <div class="card-body">
                                             <div class="dt-responsive table-responsive">
                                                  <table id="table_cart" class="table table-striped table-bordered nowrap">
                                                       <thead>
                                                            <tr>
                                                                 <th class="border-top-0">ภาพ</th>
                                                                 <th class="text-left border-top-0">SKU</th>
                                                                 <th class="text-left border-top-0">ชื่อ</th>
                                                                 {{-- @foreach ($currencies as $currency)
                                                                      <th class="border-top-0 {{$currency->variable}}">{{$currency->name_th}}</th>
                                                                 @endforeach --}}
                                                                 <th class="text-right border-top-0 price_bath">ราคาขาย(บาท)</th>
                                                                 <th class="text-right border-top-0 price_lak">ราคาขาย(กีบ)</th>
                                                                 {{-- <th class="border-top-0 price_usd">ราคาขาย(ดอลลาร์สหรัฐ)</th>
                                                                 <th class="border-top-0 price_khr">ราคาขาย(เรียลกัมพูชา)</th> --}}
                                                                 <th class="text-right border-top-0">จำนวน</th>
                                                                 {{-- @foreach ($currencies as $currency)
                                                                      <th class="border-top-0 {{$currency->variable}}">รวมราคา{{$currency->name_th}}</th>
                                                                 @endforeach --}}
                                                                 <th class="text-right border-top-0 price_bath">รวมราคา(บาท)</th>
                                                                 <th class="text-right border-top-0 price_lak">รวมราคา(กีบ)</th>
                                                                 {{-- <th class="border-top-0 price_usd">รวมราคา(ดอลลาร์สหรัฐ)</th>
                                                                 <th class="border-top-0 price_khr">รวมราคา(เรียลกัมพูชา)</th> --}}
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                       </tbody>
                                                       <tfoot>
                                                            <tr>
                                                                 <td colspan="6" class="text-right text-primary">ราคาก่อนหักส่วนลด</td>
                                                                 {{-- @foreach ($currencies as $currency)
                                                                      <td id="sum_{{$currency->variable}}" class="text-right text-primary"></td>
                                                                 @endforeach --}}
                                                                 <td id="sum_price_bath" class="text-right text-primary"></td>
                                                                 <td id="sum_price_lak" class="text-right text-primary"></td>
                                                                 {{-- <td id="sum_price_usd" class="text-right text-primary"></td>
                                                                 <td id="sum_price_khr" class="text-right text-primary"></td> --}}
                                                            </tr>
                                                            <tr>
                                                                 <td colspan="6" class="text-right text-danger">Discount</td>
                                                                 {{-- @foreach ($currencies as $currency)
                                                                      <td id="dc_{{$currency->variable}}" class="text-right text-danger"></td>
                                                                 @endforeach --}}
                                                                 <td id="dc_price_bath" class="text-right text-danger"></td>
                                                                 <td id="dc_price_lak" class="text-right text-danger"></td>
                                                                 {{-- <td id="dc_price_usd" class="text-right text-danger"></td>
                                                                 <td id="dc_price_khr" class="text-right text-danger"></td> --}}
                                                            </tr>
                                                            <tr>
                                                                 <td colspan="6" class="text-right text-success">ราคาหลังหักส่วนลด</td>
                                                                 {{-- @foreach ($currencies as $currency)
                                                                      <td id="total_{{$currency->variable}}" class="text-right text-success"></td>
                                                                 @endforeach --}}
                                                                 <td id="total_price_bath" class="text-right text-success"></td>
                                                                 <td id="total_price_lak" class="text-right text-success"></td>
                                                                 {{-- <td id="total_price_usd" class="text-right text-success"></td>
                                                                 <td id="total_price_khr" class="text-right text-success"></td> --}}
                                                            </tr>
                                                       </tfoot>
                                                  </table>
                                             </div>
                                             <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-save mr-2"></i>สร้างใบสั่งซื้อ</button>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </form>
               </div>
          </div>
     </div>
@endsection
@section('js_bottom')
     <!-- jquery-validation Js -->
     <script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
     <!-- sweet alert Js -->
     <script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>
     <!-- datatable Js -->
     <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>
     <!-- select2 Js -->
     <script src="{{asset('assets/js/plugins/select2.full.min.js')}}"></script>
     <!-- datepicker js -->
     <script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>
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
          $("#discount").val(0);
          $("#transfer_cod_amount").val(0);

          setTimeout(function() {
               $('#simpletable').DataTable({
                    "scrollY": "500px",
                    "scrollCollapse": true,
                    "paging": false
               });

               $('#scr-vrt-dt2').DataTable({
                    "scrollY": "500px",
                    "scrollCollapse": true,
                    "paging": false
               });
          });

          $(".js-example-basic-single").select2();

          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });

          $(function() {
               $('input[name="transfer_date"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 2020,
                    maxYear: parseInt(moment().format('YYYY'),10),
                    locale: {
                         format: 'DD MMM YYYY'
                    }
               });
          });

          function numIndex() {
               var sum_bath = 0;
               var sum_lak = 0;
               // var sum_usd = 0;
               // var sum_khr = 0;
               $.each($('#table_cart').find('.sum_price_bath'), function (index, el) {
                    sum_bath = sum_bath + parseFloat(deleteNumformat($(el).html()));
               });
               $.each($('#table_cart').find('.sum_price_lak'), function (index, el2) {
                    sum_lak = sum_lak + parseFloat(deleteNumformat($(el2).html()));
               });
               // $.each($('#table_cart').find('.sum_price_usd'), function (index, el3) {
               //      sum_usd = sum_usd + parseFloat(deleteNumformat($(el3).html()));
               // });
               // $.each($('#table_cart').find('.sum_price_khr'), function (index, el4) {
               //      sum_khr = sum_khr + parseFloat(deleteNumformat($(el4).html()));
               // });
               // console.log(addNumformat(sum_bath.toFixed(2)));
               $("#sum_price_bath").text(addNumformat(sum_bath.toFixed(2)));
               $("#sum_price_lak").text(addNumformat(sum_lak.toFixed(2)));
               // $("#sum_price_usd").text(sum_usd);
               // $("#sum_price_khr").text(sum_khr);

          }

          function summary(){
               var data = $("#currency_id option:selected").data("value");
               var shipping_cost = $("#shipping_cost").val();
               if (data != 'undefined') {
                    $("#total_price_bath").html("");
                    $("#total_price_lak").html("");
                    // $("#total_price_usd").html("");
                    // $("#total_price_khr").html("");
                    if (data == "price_bath"){
                         // if ($("#dc_price_bath").text().length == 0){
                         //      dc_price_bath = 0;
                         // } else {
                         //      dc_price_bath = parseFloat(deleteNumformat($("#dc_price_bath").text()));
                         // }
                         // var total_price_bath = parseFloat(deleteNumformat($("#sum_price_bath").text())) - dc_price_bath;
                         var total_price_bath = parseFloat(deleteNumformat($("#sum_price_bath").text())) - $("#discount").val();
                         $("#total_price_bath").text(addNumformat(total_price_bath.toFixed(2)));

                         if (total_price_bath) {
                              $("#transfer_cod_amount").val(parseInt(total_price_bath) + parseInt(shipping_cost));
                         } else {
                              $("#transfer_cod_amount").val(parseInt(shipping_cost));
                         }
                    }
                    if (data == "price_lak"){
                         // if ($("#dc_price_lak").text().length == 0){
                         //      dc_price_lak = 0;
                         // } else {
                         //      dc_price_lak = parseFloat($("#dc_price_lak").text());
                         // }
                         // var total_price_lak = parseFloat(deleteNumformat($("#sum_price_lak").text())) - dc_price_lak;
                         var total_price_lak = parseFloat(deleteNumformat($("#sum_price_lak").text())) - $("#discount").val();
                         $("#total_price_lak").text(addNumformat(total_price_lak.toFixed(2)));

                         if (total_price_lak) {
                              $("#transfer_cod_amount").val(parseInt(total_price_lak) + parseInt(shipping_cost));
                         } else {
                              $("#transfer_cod_amount").val(parseInt(shipping_cost));
                         }
                    }

                    // if (data == "price_usd"){
                    //      // if ($("#dc_price_usd").text().length == 0){
                    //      //      dc_price_usd = 0;
                    //      // } else {
                    //      //      dc_price_usd = parseFloat(deleteNumformat($("#dc_price_usd").text()));
                    //      // }
                    //      // var total_price_usd = parseFloat(deleteNumformat($("#sum_price_usd").text())) - dc_price_usd;
                    //      var total_price_usd = parseFloat(deleteNumformat($("#sum_price_usd").text())) - $("#discount").val();
                    //      $("#total_price_usd").text(addNumformat(total_price_usd.toFixed(2)));
                    // }
                    // if (data == "price_khr"){
                    //      // if ($("#dc_price_khr").text().length == 0){
                    //      //      dc_price_khr = 0;
                    //      // } else {
                    //      //      dc_price_khr = parseFloat(deleteNumformat($("#dc_price_khr").text()));
                    //      // }
                    //      // var total_price_khr = parseFloat(deleteNumformat($("#sum_price_khr").text())) - dc_price_khr;
                    //      var total_price_khr = parseFloat(deleteNumformat($("#sum_price_khr").text())) - $("#discount").val();
                    //      $("#total_price_khr").text(addNumformat(total_price_khr.toFixed(2)));
                    // }
               } else {
                    swal("", "กรุณาเลือกสกุลเงินก่อน", "warning");
               }
          }

          $("#shipping_cost").keyup(function(e) {
               e.preventDefault();
               var sum = 0;
               var shipping_cost = $("#shipping_cost").val();
               var currency_id = $("#currency_id").val();
               if (currency_id.length == 0){
                    notify("top", "right", "feather icon-layers", "danger", "", "", "กรุณาเลือกสกุลเงิน");
                    $("#shipping_cost").val("");
               }else{
                    summary();
                    // sum = total_price + shipping_cost;
                    // $("#transfer_cod_amount").val(sum);
               }
          });

          $("#discount").keyup(function(e) {
               e.preventDefault();
               var data = $("#currency_id option:selected").data("value");
               $("#dc_price_bath").html("");
               $("#dc_price_lak").html("");
               // $("#dc_price_usd").html("");
               // $("#dc_price_khr").html("");
               if (data == "price_bath"){
                    $("#dc_price_bath").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
               } else if (data == "price_lak") {
                    $("#dc_price_lak").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
               }
               // else if (data == "price_usd") {
               //      $("#dc_price_usd").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
               // } else if (data == "price_khr") {
               //      $("#dc_price_khr").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
               // }
               summary();
          });

          $("#currency_id").change(function(e) {
               e.preventDefault();
               var data = $("#currency_id option:selected").data("value");
               $("#dc_price_bath").html("");
               $("#dc_price_lak").html("");
               // $("#dc_price_usd").html("");
               // $("#dc_price_khr").html("");
               if (data == "price_bath"){
                    $("#dc_price_bath").text( addNumformat(parseFloat($("#discount").val()).toFixed(2)));
               } else if (data == "price_lak") {
                    $("#dc_price_lak").text( addNumformat(parseFloat($("#discount").val()).toFixed(2)));
               }
               // else if (data == "price_usd") {
               //      $("#dc_price_usd").text( addNumformat(parseFloat($("#discount").val()).toFixed(2)));
               // } else if (data == "price_khr") {
               //      $("#dc_price_khr").text( addNumformat(parseFloat($("#discount").val()).toFixed(2)));
               // }
               summary();
          });

          $("#company_id").change(function(e) {
               e.preventDefault();
               $(".input-number").val(0);
               $(".input-number2").val(0);
               $("#simpletable").dataTable().fnClearTable();
               $("#simpletable").dataTable().fnDraw();
               $("#simpletable").dataTable().fnDestroy();
               $("#table_cart").dataTable().fnClearTable();
               $("#table_cart").dataTable().fnDraw();
               $("#table_cart").dataTable().fnDestroy();
               $.ajax({
                    method : "POST",
                    url : '{{ route('order.get_product_company') }}',
                    dataType : 'json',
                    data : {"company_id" : $(this).val()},
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                         $(".preloader").css("display", "block");
                    },
               }).done(function(rec){
                    let img = '';
                    let column1 = '';
                    let column2 = '';
                    let column3 = '';
                    let column4 = '';
                    // let column8 = '';
                    // let column9 = '';
                    let column5 = '';
                    let column6 = '';
                    let column7 = '';
                    $(".preloader").css("display", "none");
                    $("#simpletable tbody").empty();
                    $("#simpletable").dataTable().fnClearTable();
                    $("#simpletable").dataTable().fnDraw();
                    $("#simpletable").dataTable().fnDestroy();
                    if (rec.products.length > 0){
                         $.each(rec.products, function( key, data ) {
                              img = '{{ asset('uploads/products') }}' + '/' + data.image;
                              column1 += '<div class="d-inline-block align-middle">';
                              column1 += '<img src="'+img+'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">';
                              column1 += '</div>';
                              column2 += data.sku + '<br/>' + data.name;
                              column3 += data.price_bath;
                              column4 += data.price_lak;
                              // column8 += data.price_usd;
                              // column9 += data.price_khr;
                              column5 += data.product_type.name;
                              column6 += data.in_stock;
                              column7 += '<div class="btn-group w-75" role="group" aria-label="Basic example">';
                              column7 += '<button type="button" class="btn btn-danger btn-number btn-sm" data-type="minus" data-field="quant['+key+']" title="หยิบออกจากรถเข็น">';
                              column7 += '<span class="fas fa-minus-circle"></span>';
                              column7 += '</button>';
                              column7 += '<button type="button" class="btn btn-success btn-number btn-sm" data-type="plus" data-field="quant['+key+']" title="หยิบใส่รถเข็น">';
                              column7 += '<span class="fas fa-cart-plus"></span>';
                              column7 += '</button>';
                              column7 += '</div>';
                              column7 += '<div class="form-group">';
                              column7 += '<input type="text" name="quant['+key+']" id="product_id_'+data.id+'" class="w-75 input-number number-only form-control" value="0" min="0" max="'+data.in_stock+'" data-value="'+data.id+'">';
                              column7 += '</div>';

                              // $("#simpletable").DataTable().row.add([column1, column2, column3, column4, column8, column9, column5, column6, column7]).draw();
                              $("#simpletable").DataTable().row.add([column1, column2, column3, column4, column5, column6, column7]).draw();

                              img = '';
                              column1 = '';
                              column2 = '';
                              column3 = '';
                              column4 = '';
                              // column8 = '';
                              // column9 = '';
                              column5 = '';
                              column6 = '';
                              column7 = '';
                         });

                         $('.btn-number').click(function(e){
                              e.preventDefault();
                              fieldName = $(this).attr('data-field');
                              type      = $(this).attr('data-type');
                              var input = $("input[name='"+fieldName+"']");
                              var currentVal = parseInt(input.val());
                              if (!isNaN(currentVal)) {
                                   if(type == 'minus') {
                                        if(currentVal > input.attr('min')) {
                                             input.val(currentVal - 1).change();
                                        }
                                        if(parseInt(input.val()) == input.attr('min')) {
                                             $(this).attr('disabled', true);
                                        }
                                   } else if(type == 'plus') {
                                        if(currentVal < input.attr('max')) {
                                             input.val(currentVal + 1).change();
                                        }
                                        if(parseInt(input.val()) == input.attr('max')) {
                                             $(this).attr('disabled', true);
                                        }
                                   }
                              } else {
                                   input.val(0);
                              }
                         });
                         $('.input-number').focusin(function(){
                              $(this).data('oldValue', $(this).val());
                         });
                         $('.input-number').change(function() {
                              minValue =  parseInt($(this).attr('min'));
                              maxValue =  parseInt($(this).attr('max'));
                              valueCurrent = parseInt($(this).val());
                              product_id = $(this).data("value");
                              $.ajax({
                                   method : "post",
                                   url : '{{ route('order.get_product') }}',
                                   dataType : 'json',
                                   data: {"product_id" : product_id, "valueCurrent" : valueCurrent},
                                   beforeSend: function() {
                                        $("#preloaders").css("display", "block");
                                   },
                              }).done(function(rec){
                                   $("#preloaders").css("display", "none");
                                   let tr = '';
                                   if(rec.status==1){
                                        if ($('#table_cart').find("#row_"+rec.product_id).length == 1){
                                             $("#row_" + product_id).remove();
                                        }
                                        if (valueCurrent == 0) {
                                             $("#row_" + product_id).remove();
                                        } else {
                                             tr += '<tr id="row_'+rec.product_id+'">';
                                             tr += '<td>';
                                             tr += '<div class="d-inline-block align-middle">';
                                             tr += '<img src="'+url_gb+'/uploads/products/'+rec.image+'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">';
                                             tr += '<input type="hidden" name="product_id[]" value="'+rec.product_id+'">';
                                             tr += '<input type="hidden" name="product_amount[]" value="'+valueCurrent+'">';
                                             tr += '</div>';
                                             tr += '</td>';
                                             tr += '<td class="text-left">'+rec.sku+'</td>';
                                             tr += '<td class="text-left">'+rec.name+'</td>';
                                             tr += '<td class="price_bath text-right">'+rec.price_bath+'</td>';
                                             tr += '<td class="price_lak text-right">'+rec.price_lak+'</td>';
                                             // tr += '<td class="price_usd text-right">'+rec.price_usd+'</td>';
                                             // tr += '<td class="price_khr text-right">'+rec.price_khr+'</td>';
                                             // tr += '<td class="text-right">'+addNumformat((rec.price_bath).toFixed(2))+'</td>';
                                             // tr += '<td class="text-right">'+addNumformat((rec.price_lak).toFixed(2))+'</td>';
                                             // tr += '<td class="text-right">'+addNumformat((rec.price_usd).toFixed(2))+'</td>';
                                             // tr += '<td class="text-right">'+addNumformat((rec.price_khr).toFixed(2))+'</td>';
                                             tr += '<td class="text-right"><span id="product_amount_'+rec.product_id+'">'+valueCurrent+'<span></td>';
                                             tr += '<td class="sum_price_bath price_bath text-right">'+addNumformat((rec.sum_bath).toFixed(2))+'</td>';
                                             tr += '<td class="sum_price_lak price_lak text-right">'+addNumformat((rec.sum_lak).toFixed(2))+'</td>';
                                             // tr += '<td class="sum_price_usd price_usd text-right">'+addNumformat((rec.sum_usd).toFixed(2))+'</td>';
                                             // tr += '<td class="sum_price_khr price_khr text-right">'+addNumformat((rec.sum_khr).toFixed(2))+'</td>';
                                             tr += '</tr>';
                                             $("#table_cart > tbody:last").append(tr);
                                        }
                                        numIndex();
                                        summary();
                                   } else {
                                        swal("", rec.content, "warning");
                                        $("#product_id_"+ product_id).val(rec.amount);
                                   }
                              }).fail(function(){
                                   $("#preloaders").css("display", "none");
                                   swal("", rec.content, "error");
                              });

                              name = $(this).attr('name');
                              if(valueCurrent >= minValue) {
                                   $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
                              } else {
                                   // alert('Sorry, the minimum value was reached');
                                   $(this).val($(this).data('oldValue'));
                              }
                              if(valueCurrent <= maxValue) {
                                   $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
                              } else {
                                   // alert('Sorry, the maximum value was reached');
                                   $(this).val($(this).data('oldValue'));
                              }

                         });
                         $(".input-number").keydown(function (e) {
                              // Allow: backspace, delete, tab, escape, enter and .
                              if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                              // Allow: Ctrl+A
                              (e.keyCode == 65 && e.ctrlKey === true) ||
                              // Allow: home, end, left, right
                              (e.keyCode >= 35 && e.keyCode <= 39)) {
                                   // let it happen, don't do anything
                                   return;
                              }
                              // Ensure that it is a number and stop the keypress
                              if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                   e.preventDefault();
                              }
                         });
                         $("#discount").keyup(function(e) {
                              e.preventDefault();
                              var data = $("#currency_id option:selected").data("value");
                              $("#dc_price_bath").html("");
                              $("#dc_price_lak").html("");
                              // $("#dc_price_usd").html("");
                              // $("#dc_price_khr").html("");
                              if (data == "price_bath"){
                                   $("#dc_price_bath").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
                              } else if (data == "price_lak") {
                                   $("#dc_price_lak").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
                              }
                              // else if (data == "price_usd") {
                              //      $("#dc_price_usd").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
                              // } else if (data == "price_khr") {
                              //      $("#dc_price_khr").text( addNumformat(parseFloat($(this).val()).toFixed(2)));
                              // }
                         });

                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });
          });

          $("#customer_id").change(function (e) {
               e.preventDefault();
               $.ajax({
                    method : "post",
                    url : '{{ route('order.get_customer') }}',
                    dataType : 'json',
                    data: {"customer_id" : $(this).val()},
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                         $("#customer_name").val("");
                         $("#customer_address").text("");
                         $("#customer_city").val("");
                         $("#laos_distict_id").val("");
                         $("#customer_phone").val("");
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    $("#customer_name").val(rec.name);
                    $("#customer_address").text(rec.address);
                    $("#customer_city").val(rec.city);
                    $("#laos_distict_id").val(rec.district_id).trigger("change");
                    $("#customer_phone").val(rec.phone_number);
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });
          });

          $('.btn-number').click(function(e){
               e.preventDefault();
               fieldName = $(this).attr('data-field');
               type      = $(this).attr('data-type');
               var input = $("input[name='"+fieldName+"']");
               var currentVal = parseInt(input.val());
               if (!isNaN(currentVal)) {
                    if(type == 'minus') {

                         if(currentVal > input.attr('min')) {
                              input.val(currentVal - 1).change();
                         }
                         if(parseInt(input.val()) == input.attr('min')) {
                              $(this).attr('disabled', true);
                         }

                    } else if(type == 'plus') {

                         if(currentVal < input.attr('max')) {
                              input.val(currentVal + 1).change();
                         }
                         if(parseInt(input.val()) == input.attr('max')) {
                              $(this).attr('disabled', true);
                         }

                    }
               } else {
                    input.val(0);
               }
          });

          $('.input-number').focusin(function(){
               $(this).data('oldValue', $(this).val());
          });

          $('.input-number').change(function() {
               minValue =  parseInt($(this).attr('min'));
               maxValue =  parseInt($(this).attr('max'));
               valueCurrent = parseInt($(this).val());
               product_id = $(this).data("value");
               $.ajax({
                    method : "post",
                    url : '{{ route('order.get_product') }}',
                    dataType : 'json',
                    data: {"product_id" : product_id, "valueCurrent" : valueCurrent},
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    let tr = '';
                    if(rec.status==1){
                         if ($('#table_cart').find("#row_"+rec.product_id).length == 1){
                              $("#row_" + product_id).remove();
                         }
                         if (valueCurrent == 0) {
                              $("#row_" + product_id).remove();
                         } else {
                              tr += '<tr id="row_'+rec.product_id+'">';
                              tr += '<td>';
                              tr += '<div class="d-inline-block align-middle">';
                              tr += '<img src="'+url_gb+'/uploads/products/'+rec.image+'" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">';
                              tr += '<input type="hidden" name="product_id[]" value="'+rec.product_id+'">';
                              tr += '<input type="hidden" name="product_amount[]" value="'+valueCurrent+'">';
                              tr += '</div>';
                              tr += '</td>';
                              tr += '<td class="text-left">'+rec.sku+'</td>';
                              tr += '<td class="text-left">'+rec.name+'</td>';
                              tr += '<td class="price_bath text-right">'+rec.price_bath+'</td>';
                              tr += '<td class="price_lak text-right">'+rec.price_lak+'</td>';
                              // tr += '<td class="price_usd text-right">'+rec.price_usd+'</td>';
                              // tr += '<td class="price_khr text-right">'+rec.price_khr+'</td>';
                              // tr += '<td class="text-right">'+addNumformat((rec.price_bath).toFixed(2))+'</td>';
                              // tr += '<td class="text-right">'+addNumformat((rec.price_lak).toFixed(2))+'</td>';
                              // tr += '<td class="text-right">'+addNumformat((rec.price_usd).toFixed(2))+'</td>';
                              // tr += '<td class="text-right">'+addNumformat((rec.price_khr).toFixed(2))+'</td>';
                              tr += '<td class="text-right"><span id="product_amount_'+rec.product_id+'">'+valueCurrent+'<span></td>';
                              tr += '<td class="price_bath text-right">'+addNumformat((rec.sum_bath).toFixed(2))+'</td>';
                              tr += '<td class="price_lak text-right">'+addNumformat((rec.sum_lak).toFixed(2))+'</td>';
                              // tr += '<td class="price_usd text-right">'+addNumformat((rec.sum_usd).toFixed(2))+'</td>';
                              // tr += '<td class="price_khr text-right">'+addNumformat((rec.sum_khr).toFixed(2))+'</td>';
                              tr += '</tr>';
                              $("#table_cart > tbody:last").append(tr);
                         }
                         numIndex();
                         summary();
                    } else {
                         swal("", rec.content, "warning");
                         $("#product_id_"+ product_id).val(rec.amount);
                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });

               name = $(this).attr('name');
               if(valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
               } else {
                    // alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
               }
               if(valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
               } else {
                    // alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
               }

          });

          $(".input-number").keydown(function (e) {
               // Allow: backspace, delete, tab, escape, enter and .
               if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
               // Allow: Ctrl+A
               (e.keyCode == 65 && e.ctrlKey === true) ||
               // Allow: home, end, left, right
               (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
               }
               // Ensure that it is a number and stop the keypress
               if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
               }
          });

          $('.btn-number2').click(function(e){
               e.preventDefault();
               fieldName = $(this).attr('data-field');
               type      = $(this).attr('data-type');
               var input = $("input[name='"+fieldName+"']");
               var currentVal = parseInt(input.val());
               if (!isNaN(currentVal)) {
                    if(type == 'minus') {
                         if(currentVal > input.attr('min')) {
                              input.val(currentVal - 1).change();
                         }
                         if(parseInt(input.val()) == input.attr('min')) {
                              $(this).attr('disabled', true);
                         }
                    } else if(type == 'plus') {

                         if(currentVal < input.attr('max')) {
                              input.val(currentVal + 1).change();
                         }
                         if(parseInt(input.val()) == input.attr('max')) {
                              $(this).attr('disabled', true);
                         }
                    }
               } else {
                    input.val(0);
               }
          });

          $('.input-number2').focusin(function(){
               $(this).data('oldValue', $(this).val());
          });

          $('.input-number2').change(function() {
               minValue =  parseInt($(this).attr('min'));
               maxValue =  parseInt($(this).attr('max'));
               valueCurrent = parseInt($(this).val());
               box_id = $(this).data("value");
               $.ajax({
                    method : "post",
                    url : '{{ route('order.get_box') }}',
                    dataType : 'json',
                    data: {"box_id" : box_id, "valueCurrent" : valueCurrent},
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    let tr = '';
                    if(rec.status==1){
                         if ($('#table_cart').find("#row_box"+rec.box_id).length == 1){
                              $("#row_box" + box_id).remove();
                         }
                         if (valueCurrent == 0){
                              $("#row_box" + box_id).remove();
                         } else {
                              tr += '<tr id="row_box'+rec.box_id+'">';
                              tr += '<td>';
                              tr += '<div class="d-inline-block align-middle">';
                              tr += '<img src="'+url_gb+'/assets/images/product/'+rec.image+'" alt="" class="img-radius align-top m-r-15" style="width:40px;">';
                              tr += '<input type="hidden" name="box_id[]" value="'+rec.box_id+'">';
                              tr += '<input type="hidden" name="box_amount[]" value="'+valueCurrent+'">';
                              tr += '</div>';
                              tr += '</td>';
                              tr += '<td>-</td>';
                              tr += '<td class="text-left">'+rec.size+'<br/>'+rec.description+'</td>';
                              tr += '<td class="price_bath text-right">'+rec.price_bath+'</td>';
                              tr += '<td class="price_lak text-right">'+rec.price_lak+'</td>';
                              // tr += '<td class="price_usd text-right">'+rec.price_usd+'</td>';
                              // tr += '<td class="price_khr text-right">'+rec.price_khr+'</td>';
                              tr += '<td class="text-right"><span id="box_amount_'+rec.box_id+'">'+valueCurrent+'</span></td>';
                              tr += '<td class="sum_price_bath price_bath text-right">'+addNumformat((rec.sum_bath).toFixed(2))+'</td>';
                              tr += '<td class="sum_price_lak price_lak text-right">'+addNumformat((rec.sum_lak).toFixed(2))+'</td>';
                              // tr += '<td class="sum_price_usd price_usd text-right">'+addNumformat((rec.sum_usd).toFixed(2))+'</td>';
                              // tr += '<td class="sum_price_khr price_khr text-right">'+addNumformat((rec.sum_khr).toFixed(2))+'</td>';
                              tr += '</tr>';
                              $("#table_cart > tbody:last").append(tr);
                         }
                         numIndex();
                         summary();
                    } else {
                         swal("", rec.content, "warning");
                         // $("#product_id_"+ product_id).val(rec.amount);
                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });

               name = $(this).attr('name');
               if(valueCurrent >= minValue) {
                    $(".btn-number2[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
               } else {
                    // alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
               }
               if(valueCurrent <= maxValue) {
                    $(".btn-number2[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
               } else {
                    // alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
               }

          });

          $(".input-number2").keydown(function (e) {
               // Allow: backspace, delete, tab, escape, enter and .
               if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
               // Allow: Ctrl+A
               (e.keyCode == 65 && e.ctrlKey === true) ||
               // Allow: home, end, left, right
               (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
               }
               // Ensure that it is a number and stop the keypress
               if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
               }
          });
     });


     $('#FormAdd').validate({
          ignore: '.ignore, .select2-input',
          focusInvalid: true,
          rules: {
               'currency_id' : {
                    required: true
               },
               'shipping_id' : {
                    required: true
               },
               'company_id' : {
                    required: true
               },
               'customer_name' : {
                    required: true
               },
               'customer_address' : {
                    required: true
               },
               'customer_city' : {
                    required: true
               },
               'laos_distict_id' : {
                    required: true
               },
               'customer_phone' : {
                    required: true
               },
               'product_id' : {
                    required: true
               },
               'transfer_currency_id' : {
                    required: function (element) {
                         var preview_img = $("#preview_img").attr("src");
                         var myarr = preview_img.split("/");
                         var myarr = myarr[myarr.length - 1];
                         if (myarr == 'prod-0.jpg'){
                              return false;
                         } else {
                              return true;
                         }
                    }
               },
               'transfer_price' : {
                    required: function (element) {
                         var preview_img = $("#preview_img").attr("src");
                         var myarr = preview_img.split("/");
                         var myarr = myarr[myarr.length - 1];
                         if (myarr == 'prod-0.jpg'){
                              return false;
                         } else {
                              return true;
                         }
                    }
               },
               'transfer_date' : {
                    required: function (element) {
                         var preview_img = $("#preview_img").attr("src");
                         var myarr = preview_img.split("/");
                         var myarr = myarr[myarr.length - 1];
                         if (myarr == 'prod-0.jpg'){
                              return false;
                         } else {
                              return true;
                         }
                    }
               },
               'hours' : {
                    required: function (element) {
                         var preview_img = $("#preview_img").attr("src");
                         var myarr = preview_img.split("/");
                         var myarr = myarr[myarr.length - 1];
                         if (myarr == 'prod-0.jpg'){
                              return false;
                         } else {
                              return true;
                         }
                    }
               },
               'minutes' : {
                    required: function (element) {
                         var preview_img = $("#preview_img").attr("src");
                         var myarr = preview_img.split("/");
                         var myarr = myarr[myarr.length - 1];
                         if (myarr == 'prod-0.jpg'){
                              return false;
                         } else {
                              return true;
                         }
                    }
               },
          },
          // Errors //
          errorPlacement: function errorPlacement(error, element) {
               var $parent = $(element).parents('.form-group');
               // Do not duplicate errors
               if ($parent.find('.jquery-validation-error').length) {
                    return;
               }
               $parent.append(
                    error.addClass('jquery-validation-error small form-text invalid-feedback')
               );

          },
          highlight: function(element) {
               var $el = $(element);
               var $parent = $el.parents('.form-group');

               $el.addClass('is-invalid');

               // Select2 and Tagsinput
               if ($el.hasClass('select2-hidden-accessible') || $el.attr('data-role') === 'tagsinput') {
                    $el.parent().addClass('is-invalid');
                    // $el.parent().focus();
               }
               // $el.focus();
               // $(window).scrollTop($('.is-invalid').offset().top);
               // $("html, body").delay(300).animate({
               //      scrollTop: $el.offset().top
               // }, 2000);
          },
          unhighlight: function(element) {
               $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');
          },
          submitHandler: function (form) {
               var form = $('#FormAdd')[0];
               var formData = new FormData(form);
               $.ajax({
                    method : "POST",
                    url : '{{ route('order.store') }}',
                    dataType : 'json',
                    data : formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                         $("#preloaders").css("display", "block");
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    if (rec.status == 1) {
                         swal("", rec.content, "success").then(function(){
                              window.location.href = "{{ route('order') }}";
                         });
                    } else {
                         if (rec.attr){
                              var value = $("[name="+rec.attr+"]").addClass('is-invalid');;
                         }
                         swal("", rec.content, "warning");
                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
               });
          },
          invalidHandler: function (form) {
               $("#preloaders").css("display", "none");
          }
     });

     function readURL(input) {
          if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function (e) {
                    $('#preview_img').attr('src', e.target.result);
               }
               reader.readAsDataURL(input.files[0]);
          }
     }
     </script>
@endsection
