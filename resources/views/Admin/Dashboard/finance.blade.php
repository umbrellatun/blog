@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
         <div class="col-sm-12">
             <div class="card">
                 <div class="card-header">
                    <h5>Dashboard</h5>
                 </div>
                 <div class="card-body">
                      <div class="row">
                           <div class="col-sm-12">
            				<div class="card">
            					<div class="card-body">
            						<h5 class="mb-3">รายรับของฉัน</h5>
            						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            							<li class="nav-item">
            								<a class="nav-link active" style="color: #FFF !important;" id="pills-income-tab" data-toggle="pill" href="#pills-income" role="tab" aria-controls="pills-income" aria-selected="true">ที่สำเร็จแล้ว</a>
            							</li>
            							<li class="nav-item">
            								<a class="nav-link" style="color: #FFF !important;" id="pills-waitAttachFile-tab" data-toggle="pill" href="#pills-waitAttachFile" role="tab" aria-controls="pills-waitAttachFile" aria-selected="true">รอแนบหลักฐานการโอน</a>
            							</li>
            						</ul>
            						<div class="tab-content" id="pills-tabContent">
                                             <div class="tab-pane fade show active" id="pills-income" role="tabpanel" aria-labelledby="pills-income-tab">
                                                  <div class="dt-responsive table-responsive">
                                                       <table id="table_cart" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                 <tr>
                                                                      <th class="border-top-0">Order NO.</th>
                                                                      <th class="border-top-0">บริษัท</th>
                                                                      <th class="border-top-0">ผู้ซื้อ</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมหยิบ(บาท)</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมแพ็ค(บาท)</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมขนส่ง(บาท)</th>
                                                                      <th class="border-top-0">รวมราคาสินค้า</th>
                                                                      <th class="border-top-0">รวมราคากล่อง</th>
                                                                      <th class="border-top-0">ค่าขนส่ง</th>
                                                                      <th class="border-top-0">ส่วนลด</th>
                                                                      <th class="border-top-0">สถานะ</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody>
                                                                 @foreach ($orders as $order)
                                                                      @if ($order->status == 'S')
                                                                           <tr>
                                                                                <td>{{$order->order_no}}</td>
                                                                                <td>{{$order->Company->name}}</td>
                                                                                <td>{{$order->Customer->name}}</td>
                                                                                <td>{{$order->pick}}</td>
                                                                                <td>{{$order->pack}}</td>
                                                                                <td>{{$order->delivery}}</td>
                                                                                <td>{{($order->OrderProduct)->sum('price_bath')}}</td>
                                                                                <td>{{($order->OrderBoxs)->sum('price_bath')}}</td>
                                                                                <td>{{$order->shipping_cost}}</td>
                                                                                <td>{{$order->discount}}</td>
                                                                                <td>{{$order->status}}</td>
                                                                           </tr>
                                                                      @endif
                                                                 @endforeach
                                                            </tbody>
                                                       </table>
                                                  </div>
            							</div>
            							<div class="tab-pane fade show" id="pills-waitAttachFile" role="tabpanel" aria-labelledby="pills-waitAttachFile-tab">
                                                  <div class="dt-responsive table-responsive">
                                                       <table id="table_cart" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                 <tr>
                                                                      <th class="border-top-0">Order NO.</th>
                                                                      <th class="border-top-0">บริษัท</th>
                                                                      <th class="border-top-0">ผู้ซื้อ</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมหยิบ(บาท)</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมแพ็ค(บาท)</th>
                                                                      <th class="border-top-0">ค่าธรรมเนียมขนส่ง(บาท)</th>
                                                                      <th class="border-top-0">รวมราคาสินค้า</th>
                                                                      <th class="border-top-0">รวมราคากล่อง</th>
                                                                      <th class="border-top-0">ค่าขนส่ง</th>
                                                                      <th class="border-top-0">ส่วนลด</th>
                                                                      <th class="border-top-0">สถานะ</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody>
                                                                 @foreach ($orders as $order)
                                                                      @if ($order->status == 'W')
                                                                           <tr>
                                                                                <td>{{$order->order_no}}</td>
                                                                                <td>{{$order->Company->name}}</td>
                                                                                <td>{{$order->Customer->name}}</td>
                                                                                <td>{{$order->pick}}</td>
                                                                                <td>{{$order->pack}}</td>
                                                                                <td>{{$order->delivery}}</td>
                                                                                <td>{{($order->OrderProduct)->sum('price_bath')}}</td>
                                                                                <td>{{($order->OrderBoxs)->sum('price_bath')}}</td>
                                                                                <td>{{$order->shipping_cost}}</td>
                                                                                <td>{{$order->discount}}</td>
                                                                                <td>{{$order->status}}</td>
                                                                           </tr>
                                                                      @endif
                                                                 @endforeach
                                                            </tbody>
                                                       </table>
                                                  </div>
            							</div>
            						</div>
            					</div>
            				</div>
            			</div>
                      </div>
                 </div>
             </div>
         </div>
     </div>
@endsection
