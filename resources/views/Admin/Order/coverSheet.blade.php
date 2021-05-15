<!DOCTYPE html>
<html lang="th">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <title>{{$order->order_no}}</title>
     <link rel="stylesheet" href="style.css" media="all" />
     <style>
     @font-face {
          font-family: myFirstFont;
         src: url({{ asset('font/SukhumvitSet-Medium.ttf') }});
     }
     .clearfix:after {
          content: "";
          display: table;
          clear: both;
     }

     a {
          color: #5D6975;
          text-decoration: underline;
     }

     body {
          position: relative;
          width: 21cm;
          height: 29.7cm;
          margin: 0 auto;
          color: #001028;
          background: #FFFFFF;
          font-size: 12px;
          font-family: Arial;
          padding: 10px 10px;
          font-family: myFirstFont, sans-serif;
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

     table tr:nth-child(2n-1) td {
          background: #F5F5F5;
     }

     table th,
     table td {
          /* text-align: center; */
     }

     table th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #C1CED9;
          white-space: nowrap;
          font-weight: normal;
     }

     table .service,
     table .desc {
          /* text-align: left; */
     }

     table td {
          padding: 20px;
          /* text-align: left; */
     }

     table td.service,
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
     <header class="clearfix">
          <div id="logo">
               <img src="{{asset('assets/images/order/logo.png')}}" style="width: 90px; height: 90px;">
          </div>
          <h1>ใบส่งสินค้า {{$order->order_no}}</h1>
          <div id="company" class="clearfix">
               <div>{{$order->Company->name}}</div>
               <div>{{$order->Company->address}}<br />{{$order->Company->Amphure->name_th}}, {{$order->Company->Province->name_th}}</div>
               <div>Tel:{{$order->Company->tel}}, Fax:{{$order->Company->fax}}</div>
               <div><a href="mailto:company@example.com">{{$order->Company->email}}</a></div>
          </div>
          <div id="project">
               <div><span>ORDER NO.</span> {{$order->order_no}}</div>
               <div><span>CLIENT</span> {{$order->customer_name}}</div>
               <div><span>ADDRESS</span> {{$order->customer_address}},{{$order->customer_city}},{{$order->LaosDistrict->name}}</div>
               {{-- <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div> --}}
               <div><span>TEL</span> {{$order->customer_phone_number}}</div>
               <div><span>ORDER DATE</span> {{$order->created_at}}</div>
               <div><span>วิธีจัดส่ง</span> {{$order->Shipping->name}} <span>ค่าจัดส่ง</span>{{$order->shipping_cost}} THB</div>
          </div>
     </header>
     <main>
          <table>
               <thead>
                    <tr>
                         <th class="service">Description</th>
                         <th class="desc">Quantity</th>
                         <th>Amount</th>
                         <th>Total</th>
                         <th>QrCode</th>
                    </tr>
               </thead>
               <tbody>
                    @foreach ($order->OrderProduct as $key => $order_product)
                         <tr>
                              <td>
                                   <h6>{{$order_product->Product->name}}</h6>
                                   <p class="m-0">{{$order_product->Product->sku}}</p>
                              </td>
                              <td>1</td>
                              <td>฿{{$order_product->price_bath}}</td>
                              <td>฿{{$order_product->price_bath}}</td>
                              <td align="center">
                                   <div class="" style="float: left; width: 80%; height: 100%; padding-top: 1.5cm; margin-left: 10%;">
                                        <barcode code="{{$order_product->qr_code}}" type="QR" size="0.8"/>
                                             <br/>
                                             {{$order_product->qr_code}}
                                        </barcode>
                                   </div>
                              </td>
                         </tr>
                    @endforeach
                    @foreach ($order->OrderBoxs as $key => $order_box)
                         <tr>
                              <td>
                                   <h6>{{$order_box->Box->size}}<br/>{{$order_box->Box->description}}</h6>
                              </td>
                              <td>1</td>
                              <td>฿{{$order_box->price_bath}}</td>
                              <td>฿{{$order_box->price_bath}}</td>
                              <td align="center">
                                   <div class="" style="width: 80%; height: 100%; padding-top: 1.5cm; margin-left: 10%;">
                                        <barcode code="{{$order_box->qr_code}}" type="QR" size="0.8"/>
                                             <br/>
                                             {{$order_box->qr_code}}
                                        </barcode>
                                   </div>
                              </td>
                         </tr>
                    @endforeach
               </tbody>
          </table>
          <div id="notices">
               <div>NOTICE:</div>
               <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
          </div>
     </main>
     <footer>
          Invoice was created on a computer and is valid without the signature and seal.
     </footer>
</body>
</html>
