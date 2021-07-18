@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
     <div class="pcoded-content">
          <!-- [ breadcrumb ] start -->
          <div class="page-header">
               <div class="page-block">
                    <div class="row align-items-center">
                         <div class="col-md-12">
                              <div class="page-header-title">
                                   <h5 class="m-b-10">Dashboard sale</h5>
                              </div>
                              <ul class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                   <li class="breadcrumb-item"><a href="#!">Dashboard sale</a></li>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
          <!-- [ breadcrumb ] end -->
          <!-- [ Main Content ] start -->
          <div class="row">
               <!-- product profit start -->
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-red">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Total Profit</h6>
                                        <h3 class="m-b-0 text-white">$1,783</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-money-bill-alt text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-blue">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Total Orders</h6>
                                        <h3 class="m-b-0 text-white">15,830</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-database text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-green">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Average Price</h6>
                                        <h3 class="m-b-0 text-white">$6,780</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-dollar-sign text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-xl-3 col-md-6">
                    <div class="card prod-p-card bg-c-yellow">
                         <div class="card-body">
                              <div class="row align-items-center m-b-0">
                                   <div class="col">
                                        <h6 class="m-b-5 text-white">Product Sold</h6>
                                        <h3 class="m-b-0 text-white">6,784</h3>
                                   </div>
                                   <div class="col-auto">
                                        <i class="fas fa-tags text-white"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- product profit end -->

               <div class="col-xl-7 col-md-12">
                    <div class="card table-card">
                         <div class="card-header">
                              <h5>รอตรวจสอบหลักฐานการชำระเงิน</h5>
                         </div>
                         <div class="pro-scroll" style="height:500px; position:relative; overflow-y: scroll;">
                              <div class="card-body p-0">
                                   <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                             <thead>
                                                  <tr>
                                                       <th>No.</th>
                                                       <th>ชื่อไฟล์</th>
                                                       <th>จำนวนเงิน</th>
                                                       <th>วันที่โอน</th>
                                                       <th>เวลาโอน</th>
                                                       <th>หมายเหตุ</th>
                                                       <th>สถานะ</th>
                                                       <th>action</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  @php $cnt = 1; @endphp
                                                  @foreach ($transfers as $key => $transfer)
                                                       <tr>
                                                            <td>{{$cnt++}}</td>
                                                            <td>{{$transfer->image}}</td>
                                                            <td>{{$transfer->amount}}</td>
                                                            <td>{{$transfer->transfer_date}}</td>
                                                            <td>{{$transfer->transfer_hours}}:{{$transfer->transfer_minutes}}</td>
                                                            <td>{{ ($transfer->note) ? $transfer->note : '-' }}</td>
                                                            <td>{{$transfer->status}}</td>
                                                            <td></td>
                                                       </tr>
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
@endsection
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/js/menu-setting.min.js') }}"></script>
