<!DOCTYPE html>
<html lang="th">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <title>เอกสารการจัดส่งพัสดุ</title>
     <style>
     @font-face {
          font-family: Baijam;
          src: url({{ asset('font/Baijam/TH Baijam.ttf') }});
     }
     body {
          position: relative;
          /* width: 21cm; */
          /* height: 29.7cm; */
          /* margin: 0 auto; */
          color: #001028;
          /* background: #FFFFFF; */
          font-size: 14px;
          /* padding: 10px 10px; */
          font-family: Baijam;
     }

     header {
          padding: 10px 10px;
          margin-bottom: 30px;
     }

     #logo {
          text-align: center;
          margin-bottom: 10px;
     }

     #logo img {
          width: 90px;
     }

     h1 {
          border-top: 1px solid  #5D6975;
          border-bottom: 1px solid  #5D6975;
          color: #5D6975;
          font-size: 2.4em;
          line-height: 1.4em;
          font-weight: normal;
          text-align: center;
          margin: 0 0 20px 0;
          background: url({{asset('assets/images/order/dimension.png')}});
     }

     #project {
          float: left;
     }

     #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 10px;
          display: inline-block;
          font-size: 0.8em;
     }

     #company {
          float: right;
          text-align: right;
     }

     #project div,
     #company div {
          white-space: nowrap;
     }

     table {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 20px;
     }

     /* table tr:nth-child(2n-1) td {
          background: #FFF;
     } */
     /* background: #F5F5F5; */

     /* table th,
     table td {
     } */
     /* text-align: center; */

     /* table th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #C1CED9;
          white-space: nowrap;
          font-weight: normal;
     }

     table .service,
     table .desc {
     } */
     /* text-align: left; */

     /* table td {
          padding: 20px;
     } */
     /* text-align: left; */

     /* table td.service,
     table td.desc {
          vertical-align: top;
     }

     table td.unit,
     table td.qty,
     table td.total {
          font-size: 1.2em;
     }

     table td.grand {
          border-top: 1px solid #5D6975;;
     } */

     #notices .notice {
          color: #5D6975;
          font-size: 1.2em;
     }

     footer {
          color: #5D6975;
          width: 100%;
          height: 30px;
          position: absolute;
          bottom: 0;
          border-top: 1px solid #C1CED9;
          padding: 10px 10px;
          text-align: center;
     }
     </style>
</head>
<body>
     @foreach ($orders as $key => $order)
          @if ($_GET["picklist_sheet"] == 'Y')

               <header class="clearfix">
                    <h1>ใบ PickList {{$order->order_no}}</h1>
                    <table>
                         <tr>
                              <td colspan="2" align="center"><b>PickList</b></td>
                         </tr>
                         <tr>
                              <td align="left">ชื่อผู้ใช้ {{ $user->name }} {{ $user->lastname }}</td>
                              <td align="left">วันที่ดาวน์โหลด {{ date_format(date_create($order->picklist_sheet_at), "d/m/Y H:i:s") }}</td>
                         </tr>
                    </table>
               </header>
               <main>
                    <table>
                         <thead>
                              <tr>
                                   <th>#</th>
                                   <th>รูปสินค้า</th>
                                   <th class="service">Description</th>
                                   <th class="desc">Quantity</th>
                                   <th>QrCode</th>
                              </tr>
                         </thead>
                         <tbody>
                              @php
                                   $i = 1;
                              @endphp
                              @foreach ($order->OrderProduct as $key => $order_product)
                                   <tr>
                                        <td>{{$i}}</td>
                                        <td><img src="{{asset('uploads/products/' . $order_product->Product->image)}}" style="width: 75px;"></td>
                                        <td>
                                             <h6>{{$order_product->Product->name}}</h6>
                                             <p class="m-0">{{$order_product->Product->sku}}</p>
                                        </td>
                                        <td>1</td>
                                        <td align="center">
                                             <div class="" style="float: left; width: 80%; height: 100%; padding-top: 1.5cm; margin-left: 10%;">
                                                  <barcode code="{{$order_product->qr_code}}" type="QR" size="0.8"/>
                                                       <br/>
                                                       {{$order_product->qr_code}}
                                                  </barcode>
                                             </div>
                                        </td>
                                   </tr>
                                   @php
                                        $i++;
                                   @endphp
                              @endforeach
                              @php
                                   $j = $i;
                              @endphp
                              @foreach ($order->OrderBoxs as $key => $order_box)
                                   <tr>
                                        <td>{{$j}}</td>
                                        <td><img src="{{asset('assets/images/product/box.jpg')}}" style="width: 75px;"></td>
                                        <td>
                                             <h6>{{$order_box->Box->size}}<br/>{{$order_box->Box->description}}</h6>
                                        </td>
                                        <td>1</td>
                                        <td align="center">
                                             <div class="" style="width: 80%; height: 100%; padding-top: 1.5cm; margin-left: 10%;">
                                                  <barcode code="{{$order_box->qr_code}}" type="QR" size="0.8"/>
                                                       <br/>
                                                       {{$order_box->qr_code}}
                                                  </barcode>
                                             </div>
                                        </td>
                                   </tr>
                                   @php
                                        $j++;
                                   @endphp
                              @endforeach
                         </tbody>
                    </table>
               </main>
               <pagebreak>
          @endif
          {{-- @if ($_GET["cover_sheet"] == 'Y')
               <header class="clearfix">
                    <table style="background: none !important;">
                         <tr >
                              <td align="center">
                                   <span style="font-size: 24px;">
                                        {{ $order->Shipping->name }}
                                   </span>
                                   <br/><br/>
                                   กรุณาพิมพ์ใบปะหน้าพัสดุนี้และติดลงบนกล่องพัสดุ
                              </td>
                              <td align="center">
                                   <barcode code="{{$order->order_no}}" type="QR" size="1.2"/>
                                        <br/>
                                        {{$order->order_no}}
                                   </barcode>
                              </td>
                         </tr>
                    </table>
                    <table style="background: none !important;">
                         <tr >
                              <td align="left" style="border: 1px solid #000;">
                                   <span style="font-size: 17px;">
                                        ผู้ส่ง (SENDER):
                                   </span>
                                   <br/>
                                   <br/>
                                   {{ $order->Company->name }}
                                   <br/>
                                   {{ $order->Company->address }}
                                   <br/>
                                   เขต/อำเภอ : {{ $order->Company->Amphure->name_th }}
                                   จังหวัด : {{ $order->Company->Province->name_th }}
                                   <br/>
                                   รหัสไปรษณีย์ {{ $order->Company->zipcode }}
                                   โทร {{ $order->Company->tel }}

                              </td>
                              <td rowspan="2" align="center" style="border: 1px solid #000;">
                                   @if ($order->cod_amount == 0)
                                        <span style="font-size: 22px;">
                                             COD<br/>
                                             ไม่ต้องเก็บเงินปลายทาง
                                        </span>
                                   @else
                                        <span style="font-size: 22px;">
                                             COD <br/>
                                             เก็บเงินปลายทาง <br/>
                                             {{ number_format($order->cod_amount,1)}} {{$order->Currency->name}}
                                        </span>
                                   @endif
                              </td>
                         </tr>
                         <tr >
                              <td align="left" style="border: 1px solid #000;">
                                   <span style="font-size: 17px;">
                                        ผู้รับ (RECIEVER):
                                   </span>
                                   <br/>
                                   <br/>
                                   {{ $order->customer_name }}
                                   <br/>
                                   {{ $order->customer_address }}
                                   <br/>
                                   เมือง : {{ $order->customer_city }}
                                   {{ $order->LaosDistrict->name }}
                                   <br/>
                                   รหัสไปรษณีย์ {{ $order->Company->zipcode }}
                                   โทร {{ $order->customer_phone_number }}
                              </td>
                         </tr>
                         <tr>
                              <td align="left" style="border: 1px solid #000;">
                                   <span style="font-size: 14px;">
                                        Order NO. : {{$order->order_no}}
                                   </span>
                              </td>
                              <td align="center" style="border: 1px solid #000;">

                              </td>
                         </tr>
                    </table>
                    --------------------------------------------------------------โปรดตัดตามเส้นประ------------------------------------------------------------------------------
                    <br/>
                    <table style="border: 1px solid #000;">
                         <thead>
                              <tr style="border: 1px solid #000;">
                                   <td>#</td>
                                   <td>Description</td>
                                   <td>Quantity</td>
                              </tr>
                         </thead>
                         <tbody>
                              @php
                                   $i = 1;
                                   $last_product_id = '';
                              @endphp
                              @foreach ($order->OrderProduct as $key => $product)
                                   @if ($last_product_id != $product->product_id)
                                        @php
                                             $last_product_id = $product->product_id;
                                        @endphp
                                        <tr>
                                             <td>{{$i}}</td>
                                             <td>{{$product->Product->name}}</td>
                                             <td>{{$product->pieces}}</td>
                                        </tr>
                                        @php
                                             $i++;
                                        @endphp
                                   @endif
                              @endforeach
                              @php
                                   $j = $i;
                                   $last_product_id = '';
                              @endphp
                              @foreach ($order->OrderBoxs as $key => $product)
                                   @if ($last_product_id != $product->box_id)
                                        @php
                                             $last_product_id = $product->box_id;
                                        @endphp
                                        <tr>
                                             <td>{{$j}}</td>
                                             <td>{{$product->Box->size}}:{{$product->Box->description}}</td>
                                             <td>{{$product->pieces}}</td>
                                        </tr>
                                        @php
                                             $i++;
                                        @endphp
                                   @endif
                              @endforeach
                         </tbody>
                    </table>
               </header>
               <main>

               </main>
               <pagebreak>
          @endif --}}
          @if ($_GET["shipping_sheet"] == 'Y')
               <header class="clearfix">
                    <table style="background: none !important;">
                         <tr >
                              <td align="center">
                                   <span style="font-size: 24px;">
                                        {{ $order->Shipping->name }}
                                   </span>
                                   <br/><br/>
                                   กรุณาพิมพ์ใบปะหน้าพัสดุนี้และติดลงบนกล่องพัสดุ
                              </td>
                              <td align="center">
                                   <barcode code="{{$order->order_no}}" type="QR" size="1.2"/>
                                        <br/>
                                        {{$order->order_no}}
                                   </barcode>
                              </td>
                         </tr>
                    </table>
                    <table style="background: none !important;">
                         <tr >
                              <td align="left" style="border: 1px solid #000;">
                                   <span style="font-size: 17px;">
                                        ผู้ส่ง (SENDER):
                                   </span>
                                   <br/>
                                   <br/>
                                   {{ $order->Company->name }}
                                   <br/>
                                   {{ $order->Company->address }}
                                   <br/>
                                   เขต/อำเภอ : {{ $order->Company->Amphure->name_th }}
                                   จังหวัด : {{ $order->Company->Province->name_th }}
                                   <br/>
                                   รหัสไปรษณีย์ {{ $order->Company->zipcode }}
                                   โทร {{ $order->Company->tel }}

                              </td>
                              <td rowspan="2" align="center" style="border: 1px solid #000;">
                                   @if ($order->cod_amount == 0)
                                        <span style="font-size: 22px;">
                                             COD<br/>
                                             ไม่ต้องเก็บเงินปลายทาง
                                        </span>
                                   @else
                                        <span style="font-size: 22px;">
                                             COD <br/>
                                             เก็บเงินปลายทาง <br/>
                                             {{ number_format($order->cod_amount,1)}} {{$order->Currency->name}}
                                        </span>
                                   @endif
                              </td>
                         </tr>
                         <tr >
                              <td align="left" style="border: 1px solid #000;">
                                   <span style="font-size: 17px;">
                                        ผู้รับ (RECIEVER):
                                   </span>
                                   <br/>
                                   <br/>
                                   {{ $order->customer_name }}
                                   <br/>
                                   {{ $order->customer_address }}
                                   <br/>
                                   เมือง : {{ $order->customer_city }}
                                   {{ $order->LaosDistrict->name }}
                                   <br/>
                                   รหัสไปรษณีย์ {{ $order->Company->zipcode }}
                                   โทร {{ $order->customer_phone_number }}
                              </td>
                         </tr>
                         <tr>
                              <td align="left" style="border: 1px solid #000;">
                                   <span style="font-size: 14px;">
                                        Order NO. : {{$order->order_no}}
                                   </span>
                              </td>
                              <td align="center" style="border: 1px solid #000;">
                                   <span style="font-size: 14px; color: #FF0000; font-weight: bold;">
                                        ใบสำหรับเจ้าหน้าที่ขนส่ง <br/> โปรดส่งคืน Admin เมื่อส่งของสำเร็จ<br/>หรือได้เงินครบแล้ว
                                   </span>
                              </td>
                         </tr>
                    </table>
                    --------------------------------------------------------------โปรดตัดตามเส้นประ------------------------------------------------------------------------------
                    <br/>
                    <table style="border: 1px solid #000;">
                         <thead>
                              <tr style="border: 1px solid #000;">
                                   <td>#</td>
                                   <td>Description</td>
                                   <td>Quantity</td>
                              </tr>
                         </thead>
                         <tbody>
                              @php
                                   $i = 1;
                                   $last_product_id = '';
                              @endphp
                              @foreach ($order->OrderProduct as $key => $product)
                                   @if ($last_product_id != $product->product_id)
                                        @php
                                             $last_product_id = $product->product_id;
                                        @endphp
                                        <tr>
                                             <td>{{$i}}</td>
                                             <td>{{$product->Product->name}}</td>
                                             <td>{{$product->pieces}}</td>
                                        </tr>
                                        @php
                                             $i++;
                                        @endphp
                                   @endif
                              @endforeach
                              @php
                                   $j = $i;
                                   $last_product_id = '';
                              @endphp
                              @foreach ($order->OrderBoxs as $key => $product)
                                   @if ($last_product_id != $product->box_id)
                                        @php
                                             $last_product_id = $product->box_id;
                                        @endphp
                                        <tr>
                                             <td>{{$j}}</td>
                                             <td>{{$product->Box->size}}:{{$product->Box->description}}</td>
                                             <td>{{$product->pieces}}</td>
                                        </tr>
                                        @php
                                             $i++;
                                        @endphp
                                   @endif
                              @endforeach
                         </tbody>
                    </table>
               </header>
               <main>

               </main>
               <pagebreak>
          @endif
          @if ($_GET["invoice_sheet"] == 'Y')
               <header class="clearfix">
                    <div id="logo">
                         <img src="{{asset('assets/images/logo-dark.png')}}">
                    </div>
                    <div id="company">
                         <h2 class="name">{{ $order->Company->name }}</h2>
                         <div>{{ $order->Company->address }} ตำบล{{ $order->Company->District->name_th }} อำเภอ{{ $order->Company->Amphure->name_th }} จังหวัด{{ $order->Company->Province->name_th }} {{ $order->Company->zipcode }}</div>
                         <div> {{ $order->Company->tel }}</div>
                         <div><a href="mailto:company@example.com">company@example.com</a></div>
                    </div>
               </header>
               <main>
                    <div id="details" class="clearfix">
                         <div id="client">
                              <div class="to">INVOICE TO:</div>
                              <h2 class="name">{{ $order->customer_name}}</h2>
                              <div class="address">{{$order->customer_address}} {{$order->customer_city}} {{$order->LaosDistrict->name}}</div>
                              <div class="tel">{{$order->customer_phone_number}}</div>
                         </div>
                         <div id="invoice">
                              <h1>INVOICE {{$order->order_no}}</h1>
                              <div class="date">Date of Invoice: {{ date_format($order->created_at, "d M Y")}}</div>
                              {{-- <div class="date">Due Date: 30/06/2014</div> --}}
                         </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                         <thead>
                              <tr>
                                   <th class="no">#</th>
                                   <th class="desc">DESCRIPTION</th>
                                   <th class="unit">UNIT PRICE</th>
                                   <th class="qty">QUANTITY</th>
                                   <th class="total">TOTAL</th>
                              </tr>
                         </thead>
                         <tbody>
                              @php
                                   $i = 1;
                                   $last_product_id = '';
                              @endphp
                              @foreach ($order->OrderProduct as $key => $product)
                                   @if ($last_product_id != $product->product_id)
                                        @php
                                             $last_product_id = $product->product_id;
                                        @endphp
                                        <tr>
                                             <td class="no">{{$i}}</td>
                                             <td class="desc"><h3>{{$product->Product->name}}</h3></td>
                                             <td class="unit">
                                                  @if ($order->currency_id == 1)
                                                       {{$order->Currency->name}}{{ number_format($product->price_bath, 2)}}
                                                  @elseif($order->currency_id == 2)
                                                       {{$order->Currency->name}}{{ number_format($product->price_lak, 2)}}
                                                  @elseif($order->currency_id == 3)
                                                       {{$order->Currency->name}}{{ number_format($product->price_usd, 2)}}
                                                  @elseif($order->currency_id == 4)
                                                       {{$order->Currency->name}}{{ number_format($product->price_khr, 2)}}
                                                  @endif
                                             </td>
                                             <td class="qty">{{$product->pieces}}</td>
                                             <td class="total">
                                                  @if ($order->currency_id == 1)
                                                       {{$order->Currency->name}}{{ number_format($product->price_bath * $product->pieces, 2)}}
                                                  @elseif($order->currency_id == 2)
                                                       {{$order->Currency->name}}{{ number_format($product->price_lak * $product->pieces, 2)}}
                                                  @elseif($order->currency_id == 3)
                                                       {{$order->Currency->name}}{{ number_format($product->price_usd * $product->pieces, 2)}}
                                                  @elseif($order->currency_id == 4)
                                                       {{$order->Currency->name}}{{ number_format($product->price_khr * $product->pieces, 2)}}
                                                  @endif
                                             </td>
                                        </tr>
                                        @php
                                             $i++;
                                        @endphp
                                   @endif
                              @endforeach
                              @php
                                   $j = $i;
                                   $last_product_id = '';
                              @endphp
                              @foreach ($order->OrderBoxs as $key => $product)
                                   @if ($last_product_id != $product->box_id)
                                        @php
                                             $last_product_id = $product->box_id;
                                        @endphp
                                        <tr>
                                             <td class="no">{{$j}}</td>
                                             <td class="desc"><h3>{{$product->Box->size}}:{{$product->Box->description}}</h3></td>
                                             <td class="unit">
                                                  @if ($order->currency_id == 1)
                                                       {{$order->Currency->name}}{{ number_format($product->price_bath, 2)}}
                                                  @elseif($order->currency_id == 2)
                                                       {{$order->Currency->name}}{{ number_format($product->price_lak, 2)}}
                                                  @elseif($order->currency_id == 3)
                                                       {{$order->Currency->name}}{{ number_format($product->price_usd, 2)}}
                                                  @elseif($order->currency_id == 4)
                                                       {{$order->Currency->name}}{{ number_format($product->price_khr, 2)}}
                                                  @endif
                                             </td>
                                             <td class="qty">{{$product->pieces}}</td>
                                             <td class="total">
                                                  @if ($order->currency_id == 1)
                                                       {{$order->Currency->name}}{{ number_format($product->price_bath * $product->pieces, 2)}}
                                                  @elseif($order->currency_id == 2)
                                                       {{$order->Currency->name}}{{ number_format($product->price_lak * $product->pieces, 2)}}
                                                  @elseif($order->currency_id == 3)
                                                       {{$order->Currency->name}}{{ number_format($product->price_usd * $product->pieces, 2)}}
                                                  @elseif($order->currency_id == 4)
                                                       {{$order->Currency->name}}{{ number_format($product->price_khr * $product->pieces, 2)}}
                                                  @endif
                                             </td>
                                        </tr>
                                        @php
                                             $i++;
                                        @endphp
                                   @endif
                              @endforeach
                         </tbody>
                         <tfoot>
                              <tr>
                                   <td colspan="2"></td>
                                   <td colspan="2">SUBTOTAL</td>
                                   <td>
                                        {{$order->Currency->name}}
                                        @if ($order->currency_id == 1)
                                             {{ number_format($order->OrderProduct->sum('price_bath') + $order->OrderBoxs->sum('price_bath'), 2) }}
                                        @elseif($order->currency_id == 2)
                                             {{ number_format($order->OrderProduct->sum('price_lak') + $order->OrderBoxs->sum('price_lak'), 2) }}
                                        @elseif($order->currency_id == 3)
                                             {{ number_format($order->OrderProduct->sum('price_usd') + $order->OrderBoxs->sum('price_usd'), 2) }}
                                        @elseif($order->currency_id == 4)
                                             {{ number_format($order->OrderProduct->sum('price_khr') + $order->OrderBoxs->sum('price_khr'), 2) }}
                                        @endif
                                   </td>
                              </tr>
                              <tr>
                                   <td colspan="2"></td>
                                   <td colspan="2">ส่วนลด</td>
                                   <td>{{$order->Currency->name}}{{number_format($order->discount, 2)}}</td>
                              </tr>
                              <tr>
                                   <td colspan="2"></td>
                                   <td colspan="2">ค่าจัดส่ง</td>
                                   <td>{{$order->Currency->name}}{{number_format($order->shipping_cost, 2)}}</td>
                              </tr>
                              @if ($order->shipping_id == 1)
                                   <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">ค่า COD</td>
                                        <td>{{$order->Currency->name}}{{number_format($order->delivery, 2)}}</td>
                                   </tr>
                              @endif

                              <tr>
                                   <td colspan="2"></td>
                                   <td colspan="2">GRAND TOTAL</td>
                                   <td>
                                        {{$order->Currency->name}}
                                        @if ($order->currency_id == 1)
                                             {{ number_format($order->OrderProduct->sum('price_bath') + $order->OrderBoxs->sum('price_bath') - $order->discount + $order->shipping_cost + $order->delivery, 2) }}
                                        @elseif($order->currency_id == 2)
                                             {{ number_format($order->OrderProduct->sum('price_lak') + $order->OrderBoxs->sum('price_lak') - $order->discount + $order->shipping_cost + $order->delivery, 2) }}
                                        @elseif($order->currency_id == 3)
                                             {{ number_format($order->OrderProduct->sum('price_usd') + $order->OrderBoxs->sum('price_usd') - $order->discount + $order->shipping_cost + $order->delivery, 2) }}
                                        @elseif($order->currency_id == 4)
                                             {{ number_format($order->OrderProduct->sum('price_khr') + $order->OrderBoxs->sum('price_khr') - $order->discount + $order->shipping_cost + $order->delivery, 2) }}
                                        @endif
                                   </td>
                              </tr>
                         </tfoot>
                    </table>
               </main>
               <pagebreak>
          @endif
     @endforeach
</body>
</html>
