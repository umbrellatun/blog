<!DOCTYPE html>
<html lang="th">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <title></title>
     <style>
     @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('font/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('font/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ asset('font/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ asset('font/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

     .clearfix:after {
       content: "";
       display: table;
       clear: both;
     }

     a {
       color: #0087C3;
       text-decoration: none;
     }

     body {
       position: relative;
       width: 21cm;
       height: 29.7cm;
       margin: 0 auto;
       color: #555555;
       background: #FFFFFF;
       font-family: Arial, sans-serif;
       font-size: 10px;
       font-family: THSarabunNew;
     }

     header {
       padding: 10px 0;
       margin-bottom: 20px;
       border-bottom: 1px solid #AAAAAA;
     }

     #logo {
       float: left;
       margin-top: 8px;
     }

     #logo img {
       height: 70px;
     }

     #company {
       float: right;
       text-align: right;
     }


     #details {
       margin-bottom: 50px;
     }

     #client {
       padding-left: 6px;
       border-left: 6px solid #0087C3;
       float: left;
     }

     #client .to {
       color: #777777;
     }

     h2.name {
       font-size: 1.4em;
       font-weight: normal;
       margin: 0;
     }

     #invoice {
       float: right;
       text-align: right;
     }

     #invoice h1 {
       color: #0087C3;
       font-size: 2.4em;
       line-height: 1em;
       font-weight: normal;
       margin: 0  0 10px 0;
     }

     #invoice .date {
       font-size: 1.1em;
       color: #777777;
     }

     table {
       width: 100%;
       border-collapse: collapse;
       border-spacing: 0;
       margin-bottom: 20px;
     }

     table th,
     table td {
       padding: 20px;
       background: #EEEEEE;
       text-align: center;
       border-bottom: 1px solid #FFFFFF;
     }

     table th {
       white-space: nowrap;
       font-weight: normal;
     }

     table td {
       text-align: right;
     }

     table td h3{
       color: #57B223;
       font-size: 1.2em;
       font-weight: normal;
       margin: 0 0 0.2em 0;
     }

     table .no {
       color: #FFFFFF;
       font-size: 1.6em;
       background: #57B223;
     }

     table .desc {
       text-align: left;
     }

     table .unit {
       background: #DDDDDD;
     }

     table .qty {
     }

     table .total {
       background: #57B223;
       color: #FFFFFF;
     }

     table td.unit,
     table td.qty,
     table td.total {
       font-size: 1.2em;
     }

     table tbody tr:last-child td {
       border: none;
     }

     table tfoot td {
       padding: 10px 20px;
       background: #FFFFFF;
       border-bottom: none;
       font-size: 1.2em;
       white-space: nowrap;
       border-top: 1px solid #AAAAAA;
     }

     table tfoot tr:first-child td {
       border-top: none;
     }

     table tfoot tr:last-child td {
       color: #57B223;
       font-size: 1.4em;
       border-top: 1px solid #57B223;

     }

     table tfoot tr td:first-child {
       border: none;
     }

     #thanks{
       font-size: 2em;
       margin-bottom: 50px;
     }

     #notices{
       padding-left: 6px;
       border-left: 6px solid #0087C3;
     }

     #notices .notice {
       font-size: 1.2em;
     }

     footer {
       color: #777777;
       width: 100%;
       height: 30px;
       position: absolute;
       bottom: 0;
       border-top: 1px solid #AAAAAA;
       padding: 8px 0;
       text-align: center;
     }
     </style>
</head>
<body>

     @foreach ($orders as $key => $order)
          {{-- <tocpagebreak type="NEXT-ODD" resetpagenum="1" pagenumstyle="i" suppress="off" />
          </tocpagebreak> --}}
          <page>
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
                    <div id="thanks">Thank you!</div>
                    <div id="notices">
                         <div>NOTICE:</div>
                         <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                    </div>
               </main>
               <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
               </footer>
          </page>
               {{-- <pagebreak type="NEXT-ODD" resetpagenum="1" pagenumstyle="i" suppress="off" /> --}}
               <pagebreak>
     @endforeach

</body>
</html>
