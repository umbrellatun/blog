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
          {{-- <header>

          </header> --}}
          <main>
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
               <pagebreak />
          </main>
     @endforeach
</body>
</html>
