<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>QR code</title>
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
               @foreach ($order->OrderProduct as $key => $order_product)
                    <div class="" style="float: left; width: 80%; height: 100%; padding-top: 1.5cm; margin-left: 10%;">
                         <barcode code="{{$order_product->qr_code}}" type="QR" size="3"/>
                              <br><br>
                              <table border="1" style="width: 92%;" cellpadding="0" cellspacing="0">
                                   <tr>
                                        <td colspan="2">&nbsp;SKU: <b>{{$order_product->qr_code}}</b></td>
                                   </tr>
                                   <tr>
                                        <td colspan="2">&nbsp;Create Date: <b>{{ date_format( $order_product->created_at, 'Y-m-d')}}</b></td>
                                   </tr>
                              </table>
                         </barcode>
                    </div>
               @endforeach
               @foreach ($order->OrderBoxs as $key => $order_box)
                    <div class="" style="float: left; width: 80%; height: 100%; padding-top: 1.5cm; margin-left: 10%;">
                         <barcode code="{{$order_box->qr_code}}" type="QR" size="3"/>
                              <br><br>
                              <table border="1" style="width: 92%;" cellpadding="0" cellspacing="0">
                                   <tr>
                                        <td colspan="2">&nbsp;SKU: <b>{{$order_box->qr_code}}</b></td>
                                   </tr>
                                   <tr>
                                        <td colspan="2">&nbsp;Create Date: <b>{{ date_format( $order_box->created_at, 'Y-m-d')}}</b></td>
                                   </tr>
                              </table>
                         </barcode>
                    </div>
               @endforeach
          </body>
          </htmlpagebody>
          <htmlpagefooter name="page-footer">
               </htmlpagefooter>
