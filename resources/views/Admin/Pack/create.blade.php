@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
     <div class="pcoded-inner-content">
          <div class="main-body">
               <div class="page-wrapper">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                         <div class="page-block">
                              <div class="row align-items-center">
                                   <div class="col-md-12">
                                        <div class="page-header-title">
                                             <h5 class="m-b-10">{{$titie}} {{$order->order_no}}</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                             <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                                             <li class="breadcrumb-item"><a href="{{route('order')}}">รายการสั่งซื้อ</a></li>
                                             <li class="breadcrumb-item"><a href="{{route('order.manage', ['id' => $order->id])}}">จัดการคำสั่งซื้อ</a></li>
                                             <li class="breadcrumb-item">{{$titie}}</li>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <form id="FormAdd">
                         <div class="row">
                              <div class="col-sm-12">
                                   <div class="card">
                                        <div class="card-body">
                                             <h5>Scan Qr-Code</h5>
                                             <hr/>
                                             <div class="form-group mb-2 col-12">
                                                  <input type="text" id="qr_code" class="form-control" placeholder="สแกน Qr-Code ที่นี่">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-xl-6 col-md-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h5>Border Bottom Color</h5>
                                        </div>
                                        <div class="card-body table-border-style">
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <thead>
                                                            <tr class="border-bottom-danger">
                                                                 <th>#</th>
                                                                 <th>ชื่อสินค้า</th>
                                                                 <th>ชิ้นที่</th>
                                                                 <th>สถานะ</th>
                                                                 <th>นำออก</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            @php $i = 1; @endphp
                                                            @foreach ($order->OrderProduct as $order_product)
                                                                 @if ($i % 2 == 0)
                                                                      @php $class = 'border-bottom-primary'; @endphp
                                                                 @else
                                                                      @php $class = 'border-bottom-warning'; @endphp
                                                                 @endif
                                                                 <tr class="{{$class}}">
                                                                      <td>{{$i}}</td>
                                                                      <td>{{$order_product->Product->name}}</td>
                                                                      <td>{{$order_product->sort}} / {{$order_product->pieces}}</td>
                                                                      <td>{{ ($order_product->status == 'Y' ? 'สแกนแล้ว' : 'รอสแกน') }}</td>
                                                                      <td></td>
                                                                 </tr>
                                                                 @php $i++; @endphp
                                                            @endforeach
                                                            {{-- <tr class="border-bottom-primary">
                                                                 <td>1</td>
                                                                 <td>Mark</td>
                                                                 <td>Otto</td>
                                                                 <td>@mdo</td>
                                                            </tr>
                                                            <tr class="border-bottom-warning">
                                                                 <td>2</td>
                                                                 <td>Jacob</td>
                                                                 <td>Thornton</td>
                                                                 <td>@fat</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>3</td>
                                                                 <td>Larry</td>
                                                                 <td>the Bird</td>
                                                                 <td>@twitter</td>
                                                            </tr> --}}
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                   </div>
                              </div>


                         </div>
                    </form>
               </div>
          </div>
     </div>
@endsection
@section('js_bottom')
     <!-- jquery-validation Js -->
     <script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
     <!-- sweet alert Js -->
     <script src="{{asset('assets/js/plugins/sweetalert.min.js')}}"></script>

     <script type="text/javascript">
         $(document).ready(function() {
              $("#pcoded").pcodedmenu({
                   themelayout: 'horizontal',
                   MenuTrigger: 'hover',
                   SubMenuTrigger: 'hover',
              });
         });
     </script>
@endsection
