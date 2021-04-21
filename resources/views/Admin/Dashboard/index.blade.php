@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
         <div class="col-sm-12">
             <div class="card">
                 <div class="card-header">
                    <h5>Dark layout</h5>
                 </div>
                 <div class="card-body">
                      <div class="row">
                           <div class="col-md-6 col-xl-3">
                                <a href="{{ route('order') }}">
                                     <div class="card bg-c-blue order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">รายการสั่งซื้อ</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-shopping-cart float-left"></i><span>{{ count($orders->where('status', '=', 'W'))}}</span></h2>
                                               <p class="m-b-0">Completed Orders<span class="float-right">351</span></p>
                                          </div>
                                     </div>
                                </a>
                           </div>
                           <div class="col-md-6 col-xl-3">
                                {{-- <a href="{{ route('transfer.list') }}"> --}}
                                <a href="#">
                                     <div class="card bg-c-green order-card">
                                          <div class="card-body">
                                               <h6 class="text-white">รอแนบหลักฐานการโอน</h6>
                                               <h2 class="text-right text-white"><i class="feather icon-tag float-left"></i><span>{{ count($orders->where('status', '=', 'WA'))}}</span></h2>
                                               <p class="m-b-0">This Month<span class="float-right">213</span></p>
                                          </div>
                                     </div>
                                </a>
                           </div>
                      </div>
                 </div>
             </div>
         </div>
     </div>
@endsection
