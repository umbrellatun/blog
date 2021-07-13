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
                           <div class="col-md-6 col-xl-2">
                                <a href="{{ route('order') }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">คำสั่งซื้อทั้งหมด</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders) }}</span></h2>
                                               {{-- <p class="m-b-0">This Month<span class="float-right">213</span></p> --}}
                                          </div>
                                     </div>
                                </a>
                           </div>
                           <div class="col-md-6 col-xl-2">
                                <a href="{{ route('dashboard.orderStatus', ['orderStatus' => 'W']) }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">ยังไม่ชำระเงิน / รอแนบหลักฐานการโอน</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders->where('status', '=', 'W')) }}</span></h2>
                                               {{-- <p class="m-b-0">This Month<span class="float-right">213</span></p> --}}
                                          </div>
                                     </div>
                                </a>
                           </div>
                           <div class="col-md-6 col-xl-2">
                                <a href="{{ route('dashboard.orderStatus', ['orderStatus' => 'WA']) }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">รอแพ็ค</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders->where('status', '=', 'WA')) }}</span></h2>
                                               {{-- <p class="m-b-0">This Month<span class="float-right">213</span></p> --}}
                                          </div>
                                     </div>
                                </a>
                           </div>
                           <div class="col-md-6 col-xl-2">
                                <a href="{{ route('dashboard.orderStatus', ['orderStatus' => 'P']) }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">รอเลขติดตามพัสดุ</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders->where('status', '=', 'P')) }}</span></h2>
                                               {{-- <p class="m-b-0">This Month<span class="float-right">213</span></p> --}}
                                          </div>
                                     </div>
                                </a>
                           </div>
                           <div class="col-md-6 col-xl-2">
                                <a href="{{ route('dashboard.orderStatus', ['orderStatus' => 'T']) }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">จัดส่งแล้ว รอปรับสถานะ</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders->where('status', '=', 'T')) }}</span></h2>
                                               {{-- <p class="m-b-0">This Month<span class="float-right">213</span></p> --}}
                                          </div>
                                     </div>
                                </a>
                           </div>
                           <div class="col-md-6 col-xl-2">
                                <a href="{{ route('dashboard.orderStatus', ['orderStatus' => 'S']) }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">ที่สำเร็จแล้ว</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders->where('status', '=', 'S')) }}</span></h2>
                                               {{-- <p class="m-b-0">This Month<span class="float-right">213</span></p> --}}
                                          </div>
                                     </div>
                                </a>
                           </div>
                           <div class="col-md-6 col-xl-2">
                                <a href="{{ route('dashboard.orderStatus', ['orderStatus' => 'C']) }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">ยกเลิก</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders->where('status', '=', 'C')) }}</span></h2>
                                               {{-- <p class="m-b-0">This Month<span class="float-right">213</span></p> --}}
                                          </div>
                                     </div>
                                </a>
                           </div>
                           {{-- <div class="col-md-6 col-xl-3">
                                <a href="{{ route('dashboard.finance') }}">
                                     <div class="card bg-c-green order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">การเงิน</h6>
                                               <h2 class="text-right text-white"><i class="fas fa-dollar-sign float-left"></i><span>{{ count($orders->where('status', '!=', 'W')) }}</span></h2>
                                          </div>
                                     </div>
                                </a>
                           </div> --}}
                      </div>
                 </div>
             </div>
         </div>
     </div>
@endsection
