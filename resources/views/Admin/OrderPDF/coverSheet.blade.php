<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>ใบปะหน้าพัสดุ</title>
<style>
@font-face {
     font-family: 'THSarabunNew';
     font-style: normal;
     font-weight: normal;
     src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
}
div {
     float: left;
}
.img_background{
     /* background-image: url("http://localhost/ThaweSubSomdet/public/uploads/guarantee.jpg"); */
     background-size: 100%;
     background-repeat: no-repeat;
}
.text-right{
     text-align: right;
}
.text-left{
     text-align: left;
}
.text-center{
     text-align: center;
}
.col-12{
     width: 100%;
}
.border{
     border: #000 solid 1px;
}
.border_none{
     border: none;
}
.border_l_r{
     border-top: 0px;
     border-bottom: 0px;
     border-left: #000 solid 1px;
     border-right: #000 solid 1px;
}
.border_t_b{
     border-left: 0px;
     border-right: 0px;
     border-top: #000 solid 1px;
     border-bottom: #000 solid 1px;
}
th{
     border: #000 solid 1px;
     font-size: 10px;
     line-height: 20px;
}
td{
     line-height: 20px;
}
table{
     border: 0px;
}
</style>
<htmlpageheader name="page-header">
     </htmlpageheader>
     <htmlpagebody>
          <body lang="th" style="font-size: 12px; line-height: 25px;">
               @foreach ($orders as $key => $order)
                    <div class="" style="border: 1px solid #000; width: 100%; height: 100%;">
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
                              <tr style="border-top: 5px solid #000; border-left: 5px solid #000; border-right: 5px solid #000;">
                                   {{-- <td align="left" style="border: 1px solid #000;"> --}}
                                   <td align="left">
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
                                   {{-- <td rowspan="2" align="center" style="border: 1px solid #000;">
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
                                   </td> --}}
                              </tr>
                              <tr style="border-top: 5px solid #000; border-left: 5px solid #000; border-right: 5px solid #000;">
                                   <td align="left">
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
                                   <td align="left">
                                        <span style="font-size: 14px;">
                                             Order NO. : {{$order->order_no}}
                                        </span>
                                   </td>
                              </tr>
                              <tr>
                                   <td align="left">
                                   @if ($order->cod_amount == 0)
                                        <span style="font-size: 22px;">
                                             COD<br/>
                                             ไม่ต้องเก็บเงินปลายทาง
                                        </span>
                                   @else
                                        <span style="font-size: 22px;">
                                             COD
                                             เก็บเงินปลายทาง
                                             {{ number_format($order->cod_amount,1)}} {{$order->Currency->name}}
                                        </span>
                                   @endif
                                   </td>
                              </tr>
                         </table>
                         {{-- <barcode code="{{$order->order_no}}"  size="1"/> --}}
                         <br><br>
                    </div>
               @endforeach
          </body>
          </htmlpagebody>
          <htmlpagefooter name="page-footer">
               </htmlpagefooter>
