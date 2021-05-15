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
            								<a class="nav-link active" style="color: #FFF !important;" id="pills-income-tab" data-toggle="pill" href="#pills-income" role="tab" aria-controls="pills-home" aria-selected="true">ที่สำเร็จแล้ว</a>
            							</li>
            							<li class="nav-item">
            								<a class="nav-link" style="color: #FFF !important;" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
            							</li>
            							<li class="nav-item">
            								<a class="nav-link" style="color: #FFF !important;" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
            							</li>
            							<li class="nav-item">
            								<a class="nav-link" style="color: #FFF !important;" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
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
            							<div class="tab-pane fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            								<p class="mb-0">Consequat occaecat ullamco amet non eiusmod nostrud dolore irure incididunt est duis anim sunt officia. Fugiat velit proident aliquip nisi incididunt nostrud exercitation proident est
            									nisi.
            									Irure magna
            									elit commodo anim ex veniam culpa eiusmod id nostrud sit cupidatat in veniam ad. Eiusmod consequat eu adipisicing minim anim aliquip cupidatat culpa excepteur quis. Occaecat sit eu exercitation
            									irure
            									Lorem incididunt nostrud.
            								</p>
            							</div>
            							<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            								<p class="mb-0">Ad pariatur nostrud pariatur exercitation ipsum ipsum culpa mollit commodo mollit ex. Aute sunt incididunt amet commodo est sint nisi deserunt pariatur do. Aliquip ex eiusmod voluptate
            									exercitation
            									cillum id incididunt elit sunt. Qui minim sit magna Lorem id et dolore velit Lorem amet exercitation duis deserunt. Anim id labore elit adipisicing ut in id occaecat pariatur ut ullamco ea tempor
            									duis.
            								</p>
            							</div>
            							<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            								<p class="mb-0">Est quis nulla laborum officia ad nisi ex nostrud culpa Lorem excepteur aliquip dolor aliqua irure ex. Nulla ut duis ipsum nisi elit fugiat commodo sunt reprehenderit laborum veniam eu
            									veniam. Eiusmod
            									minim exercitation fugiat irure ex labore incididunt do fugiat commodo aliquip sit id deserunt reprehenderit aliquip nostrud. Amet ex cupidatat excepteur aute veniam incididunt mollit cupidatat esse
            									irure officia elit do ipsum ullamco Lorem. Ullamco ut ad minim do mollit labore ipsum laboris ipsum commodo sunt tempor enim incididunt. Commodo quis sunt dolore aliquip aute tempor irure magna enim
            									minim reprehenderit. Ullamco consectetur culpa veniam sint cillum aliqua incididunt velit ullamco sunt ullamco quis quis commodo voluptate. Mollit nulla nostrud adipisicing aliqua cupidatat aliqua
            									pariatur mollit voluptate voluptate consequat non.</p>
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
