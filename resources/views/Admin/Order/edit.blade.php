@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/select2.min.css')}}">
@section('css_bottom')
     <style>

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
                                             <h5 class="m-b-10">{{$titie}}</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                             <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                                             <li class="breadcrumb-item"><a href="{{route('order')}}">รายการสั่งซื้อ</a></li>
                                             <li class="breadcrumb-item">{{$titie}}</li>
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
                                                       <input type="text" class="form-control" name="order_no" value="{{$order->order_no}}" readonly>
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="form-label">สกุลเงิน</label>
                                                       <select class="form-control" name="currency_id" id="currency_id">
                                                            <option value>กรุณาเลือก</option>
                                                            @foreach ($currencies as $currency)
                                                                 @if ($currency->id == $order->currency_id)
                                                                      @php $selected = 'selected'; @endphp
                                                                 @else
                                                                      @php $selected = ''; @endphp
                                                                 @endif
                                                                 <option value="{{$currency->id}}" {{$selected}}>{{$currency->name}}</option>
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
                                                                 @if ($company->id == $order->company_id)
                                                                      @php $selected = 'selected'; @endphp
                                                                 @else
                                                                      @php $selected = ''; @endphp
                                                                 @endif
                                                                 <option value="{{$company->id}}" {{$selected}}>{{$company->name}}</option>
                                                            @endforeach
                                                       </select>
                                                  </div>
                                             </div>
                                             <div class="col-md-12">
                                                  <div class="form-group">
                                                       <label class="form-label">ส่วนลด</label>
                                                       <input type="text" class="form-control" name="discount" id="discount" value="{{$order->discount}}" >
                                                  </div>
                                             </div>
                                             <div class="col-md-12 mb-5">
                                                  <div class="form-group">
                                                       <label class="form-label">โน็ต</label>
                                                       <textarea class="form-control" name="note" id="note">{{$order->note}}</textarea>
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
                                                       <div class="form-group">
                                                            <label class="customer_id">ลูกค้า</label>
                                                            <select class="js-example-basic-single form-control" name="customer_id" id="customer_id">
                                                                 <option value>กรุณาเลือก</option>
                                                                 @foreach ($customers as $customer)
                                                                      @if ($customer->id == $order->customer_id)
                                                                           @php $selected = 'selected'; @endphp
                                                                      @else
                                                                           @php $selected = ''; @endphp
                                                                      @endif
                                                                      <option value="{{$customer->id}}" {{$selected}}>{{$customer->name}}</option>
                                                                 @endforeach
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label class="form-label">ชื่อ - นามสกุล</label>
                                                            <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{$order->customer_name}}" >
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label class="form-label">ที่อยู่ในการจัดส่ง</label>
                                                            <textarea class="form-control" name="customer_address" id="customer_address">{{$order->customer_address}}</textarea>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label class="form-label">เมือง</label>
                                                            <input type="text" class="form-control" name="customer_city" id="customer_city" value="{{$order->customer_city}}" >
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label class="form-label">แขวง</label>
                                                            <select class="js-example-basic-single form-control" name="laos_distict_id" id="laos_distict_id">
                                                                 <option value>กรุณาเลือก</option>
                                                                 @foreach ($laos_districts as $laos_district)
                                                                      @if ($laos_district->id == $order->customer_district)
                                                                           @php $selected = 'selected'; @endphp
                                                                      @else
                                                                           @php $selected = ''; @endphp
                                                                      @endif
                                                                      <option value="{{$laos_district->id}}" {{$selected}}>{{$laos_district->name}}</option>
                                                                 @endforeach
                                                            </select>
                                                       </div>
                                                  </div>

                                             </div>
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label class="form-label">เบอร์โทรศัพท์</label>
                                                            <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="{{$order->customer_phone_number}}" >
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
                                                                      @if ($shipping->id == $order->shipping_id)
                                                                           @php $selected = 'selected'; @endphp
                                                                      @else
                                                                           @php $selected = ''; @endphp
                                                                      @endif
                                                                      <option value="{{$shipping->id}}" {{$selected}}>{{$shipping->name}}</option>
                                                                 @endforeach
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group">
                                                            <label class="form-label">ค่าจัดส่ง</label>
                                                            <input type="text" class="form-control" name="shipping_cost" id="shipping_cost" value="{{$order->shipping_cost}}" >
                                                       </div>
                                                  </div>
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
                                                  <table id="scr-vrt-dt" class="table table-striped table-bordered nowrap">
                                                       <thead>
                                                            <tr>
                                                                 <th class="border-top-0">ภาพ</th>
                                                                 <th class="border-top-0">SKU</th>
                                                                 <th class="border-top-0">ชื่อ</th>
                                                                 <th class="border-top-0">ราคาขาย(บาท)</th>
                                                                 <th class="border-top-0">ราคาขาย(กีบ)</th>
                                                                 <th class="border-top-0">ประเภท</th>
                                                                 <th class="border-top-0">จำนวนคงเหลือในโกดัง</th>
                                                                 <th class="border-top-0">action</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @foreach ($products as $key => $product)
                                                                 <tr>
                                                                      <td>
                                                                           <div class="d-inline-block align-middle">
                                                                                <img src="{{ isset($product->image) ? asset('uploads/products/'.$product->image) : asset('assets/images/product/prod-0.jpg')}}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
                                                                           </div>
                                                                      </td>
                                                                      <td>{{$product->sku}}</td>
                                                                      <td>{{$product->name}}</td>
                                                                      <td>{{$product->price_bath}}</td>
                                                                      <td>{{$product->price_lak}}</td>
                                                                      <td>{{$product->ProductType->name}}</td>
                                                                      <td>{{ isset($product->in_stock) ? $product->in_stock : 0 }}</td>
                                                                      <td>
                                                                           <div class="btn-group" role="group" aria-label="Basic example">
                                                                                <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[{{$key}}]">
                                                                                     <span class="fas fa-minus-circle"></span>
                                                                                </button>
                                                                                <input type="text" name="quant[{{$key}}]" id="product_id_{{$product->id}}" class="w-25 input-number number-only" value="0" min="0" max="{{$product->in_stock}}" data-value="{{$product->id}}">
                                                                                <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[{{$key}}]">
                                                                                     <span class="fas fa-cart-plus"></span>
                                                                                </button>
                                                                           </div>
                                                                      </td>
                                                                 </tr>
                                                            @endforeach
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="card">
                                        <div class="card-header">
                                             <h5><i class="fas fa-box-open mr-2"></i>กล่อง</h5>
                                             <span class="d-block m-t-5"></span>
                                             <hr style="border-top: 1px solid #999;"/>
                                        </div>
                                        <div class="card-body">
                                             <div class="dt-responsive table-responsive">
                                                  <table id="scr-vrt-dt2" class="table table-striped table-bordered nowrap">
                                                       <thead>
                                                            <tr>
                                                                 <th class="border-top-0">ภาพ</th>
                                                                 <th class="border-top-0">กล่อง</th>
                                                                 <th class="border-top-0">ราคาขาย(บาท)</th>
                                                                 <th class="border-top-0">ราคาขาย(กีบ)</th>
                                                                 <th class="border-top-0">action</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @php
                                                                 $box_id_arr = [];
                                                            @endphp
                                                            @foreach ($order->OrderBoxs as $order_box)
                                                                 @php
                                                                      array_push($box_id_arr, $order_box->box_id);
                                                                 @endphp
                                                            @endforeach
                                                            @foreach ($boxs as $key2 => $box)
                                                                 @if (in_array($box->id, $box_id_arr))
                                                                      @php
                                                                           $get_box = \App\Models\OrderBoxs::where('box_id', '=', $box->id)->first();
                                                                           $amount = $get_box->pieces;
                                                                       @endphp
                                                                 @else
                                                                      @php $amount = 0; @endphp
                                                                 @endif
                                                                 <tr>
                                                                      <td>
                                                                           <div class="d-inline-block align-middle">
                                                                                <img src="{{asset('assets/images/product/'.$box->image)}}" alt="user image" class="img-radius align-top m-r-15" style="width:40px;">
                                                                           </div>
                                                                      </td>
                                                                      <td>{{$box->size}} <br/> {{$box->description}}</td>
                                                                      <td>{{$box->price_bath}}</td>
                                                                      <td>{{$box->price_lak}}</td>
                                                                      <td>
                                                                           <div class="btn-group" role="group" aria-label="Basic example">
                                                                                <button type="button" class="btn btn-danger btn-number2" data-type="minus" data-field="quant_box[{{$key2}}]">
                                                                                     <span class="fas fa-minus-circle"></span>
                                                                                </button>
                                                                                <input type="text" name="quant_box[{{$key2}}]" id="box_id_{{$box->id}}" class="w-25 input-number2 number-only" min="0" max="{{$box->in_stock}}" data-value="{{$box->id}}" value="{{$amount}}">
                                                                                <button type="button" class="btn btn-success btn-number2" data-type="plus" data-field="quant_box[{{$key2}}]">
                                                                                     <span class="fas fa-cart-plus"></span>
                                                                                </button>
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
                                                                 <th class="border-top-0">SKU</th>
                                                                 <th class="border-top-0">ชื่อ</th>
                                                                 <th class="border-top-0">ราคาขาย(บาท)</th>
                                                                 <th class="border-top-0">ราคาขาย(กีบ)</th>
                                                                 <th class="border-top-0">จำนวน</th>
                                                                 <th class="border-top-0">รวมราคา(บาท)</th>
                                                                 <th class="border-top-0">รวมราคา(กีบ)</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @foreach ($order->OrderProduct as $key => $order_product)

                                                            @endforeach
                                                            @foreach ($order->OrderBoxs as $key => $order_box)
                                                                 <tr id="row_box'+rec.box_id+'">
                                                                      <td>
                                                                           <div class="d-inline-block align-middle">
                                                                                <img src="{{asset('assets/images/product/'.$box->image)}}" alt="" class="img-radius align-top m-r-15" style="width:40px;">
                                                                                <input type="hidden" name="box_id[]" value="{{$order_box->id}}">
                                                                                <input type="hidden" name="box_amount[]" value="{{$order_box->pieces}}">
                                                                           </div>
                                                                      </td>
                                                                      <td>-</td>
                                                                      <td>{{$order_box->Box->size}}<br/>{{$order_box->Box->description}}</td>
                                                                      <td>{{$order_box->Box->price_bath}}</td>
                                                                      <td>{{$order_box->Box->price_lak}}</td>
                                                                      <td><span id="box_amount_{{$order_box->id}}">{{$order_box->pieces}}</span></td>
                                                                      <td>{{ number_format(($order_box->Box->price_bath * $order_box->pieces), 2)}}</td>
                                                                      <td>{{ number_format(($order_box->Box->price_lak * $order_box->pieces), 2)}}</td>
                                                                 </tr>
                                                            @endforeach
                                                       </tbody>
                                                  </table>
                                             </div>
                                             <button type="submit" class="btn btn-primary mt-2"><i class="fas fa-receipt mr-2"></i>สร้างใบสั่งซื้อ</button>

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
     <script type="text/javascript">
         $(document).ready(function() {
              $('#scr-vrt-dt2').DataTable({
                 "scrollY": "200px",
                 "scrollCollapse": true,
                 "paging": false
             });

              $(".js-example-basic-single").select2();

              $("#pcoded").pcodedmenu({
                   themelayout: 'horizontal',
                   MenuTrigger: 'hover',
                   SubMenuTrigger: 'hover',
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
                                  tr += '<td>'+rec.sku+'</td>';
                                  tr += '<td>'+rec.name+'</td>';
                                  tr += '<td>'+rec.price_bath+'</td>';
                                  tr += '<td>'+rec.price_lak+'</td>';
                                  tr += '<td><span id="product_amount_'+rec.product_id+'">'+valueCurrent+'<span></td>';
                                  tr += '<td>'+addNumformat((rec.sum_bath).toFixed(2))+'</td>';
                                  tr += '<td>'+addNumformat((rec.sum_lak).toFixed(2))+'</td>';
                                  tr += '</tr>';
                                  $("#table_cart > tbody:last").append(tr);
                             }
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
                        alert('Sorry, the minimum value was reached');
                        $(this).val($(this).data('oldValue'));
                   }
                   if(valueCurrent <= maxValue) {
                        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
                   } else {
                        alert('Sorry, the maximum value was reached');
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
                                  tr += '<td>'+rec.size+'<br/>'+rec.description+'</td>';
                                  tr += '<td>'+rec.price_bath+'</td>';
                                  tr += '<td>'+rec.price_lak+'</td>';
                                  tr += '<td><span id="box_amount_'+rec.box_id+'">'+valueCurrent+'</span></td>';
                                  tr += '<td>'+addNumformat((rec.sum_bath).toFixed(2))+'</td>';
                                  tr += '<td>'+addNumformat((rec.sum_lak).toFixed(2))+'</td>';
                                  tr += '</tr>';
                                  $("#table_cart > tbody:last").append(tr);
                             }

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
                        alert('Sorry, the minimum value was reached');
                        $(this).val($(this).data('oldValue'));
                   }
                   if(valueCurrent <= maxValue) {
                        $(".btn-number2[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
                   } else {
                        alert('Sorry, the maximum value was reached');
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
              focusInvalid: false,
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
                   }
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
                        data : $("#FormAdd").serialize(),
                   }).done(function(rec){
                        if (rec.status == 1) {
                             swal("", rec.content, "success").then(function(){
                                  window.location.href = "{{ route('order') }}";
                             });
                        } else {
                             swal("", rec.content, "warning");
                        }
                   }).fail(function(){

                   });
              },
              invalidHandler: function (form) {

              }
         });

     </script>
@endsection
