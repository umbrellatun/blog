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
     </style>
</head>
<body>
     @foreach ($orders as $key => $order)
          <div style="border-top: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #FFF; border-left: 1px solid #000; height: 4.5cm;">
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
          </div>
          <div style="border-top: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #FFF; border-left: 1px solid #000; height: 8cm;">
               <table style="background: none !important;">
                    <tr style="border-top: 5px solid #000; border-left: 5px solid #000; border-right: 5px solid #000;">
                         <td align="left">
                              <span style="font-size: 17px;">
                                   ผู้ส่ง (SENDER):
                              </span>
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
                    </tr>
                    <tr style="border-top: 5px solid #000; border-left: 5px solid #000; border-right: 5px solid #000;">
                         <td align="left">
                              <br/>
                              <span style="font-size: 17px;">
                                   ผู้รับ (RECIEVER):
                              </span>
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
               </table>
          </div>
          <div style="border-top: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000; height: 5.3cm;">
               <table style="background: none !important;">
                    <tr>
                         <td align="center">
                         @if ($order->cod_amount == 0)
                              <span style="font-size: 22px;">
                                   ไม่ต้องเก็บเงินปลายทาง
                              </span>
                         @else
                              <span style="font-size: 22px;">
                                   <h1>COD</h1> <br/>
                                   <h2>เก็บเงินปลายทาง<br/>
                                   {{ number_format($order->cod_amount,2)}} {{$order->Currency->name}}</h2>
                              </span>
                         @endif
                         </td>
                    </tr>
               </table>
          </div>

     @endforeach
</body>
</html>
