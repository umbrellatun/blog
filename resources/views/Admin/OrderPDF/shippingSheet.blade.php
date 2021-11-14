<!DOCTYPE html>
<html lang="th">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <title>ใบปะหน้าพัสดุ</title>
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
     @endforeach
</body>
</html>
