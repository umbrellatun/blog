@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/plugins/daterangepicker.css')}}">
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
          <div class="col-sm-12">
               <div class="card">
                    <div class="card-header">
                         <h5>{{$title}}</h5>
                    </div>
                    <div class="card-body">
                         <div class="row">
                              <div class="col-md-12">
                                   <form action="{{ route('report.product') }}" method="GET" role="search">
                                        <div class="form-group">
                                             <label class="form-label">บริษัท</label>
                                             <select class="form-control" name="company_id" id="company_id">
                                                  <option value>กรุณาเลือก</option>
                                                  @foreach ($companies as $company)
                                                       @if (isset($_GET["company_id"]))
                                                            @if ($_GET["company_id"] == $company->id)
                                                                 @php $selected = 'selected'; @endphp
                                                            @else
                                                                 @php $selected = ''; @endphp
                                                            @endif
                                                       @else
                                                            @php $selected = ''; @endphp
                                                       @endif
                                                       <option value="{{$company->id}}" {{$selected}}>{{$company->name}}</option>
                                                  @endforeach
                                             </select>
                                        </div>
                                        <div class="form-group">
                                             <label class="form-label">Admin</label>
                                             <select class="form-control" name="user_id" id="user_id">
                                                  <option value="">ทั้งหมด</option>
                                                  @php $selected = ''; @endphp
                                                  @if (isset($users))
                                                       @foreach ($users as $user)
                                                            @if ($_GET["user_id"] == $user->id)
                                                                 @php $selected = 'selected'; @endphp
                                                            @else
                                                                 @php $selected = ''; @endphp
                                                            @endif
                                                            <option value="{{$user->id}}" {{$selected}}>{{$user->name}} {{$user->lastname}}</option>
                                                       @endforeach
                                                  @endif
                                             </select>
                                        </div>
                                        <div class="form-group">
                                             <label class="form-label">ช่วงวันที่</label>
                                             @if (empty($start_date))
                                                  <input type="text" name="daterange" id="daterange" class="form-control" value="" placeholder="กรุณาระบุช่วงเวลา" autocomplete="off" />
                                             @else
                                                  <input type="text" name="daterange" id="daterange" class="form-control" value="{{ date_format(date_create($start_date), "d/M/Y")}} - {{date_format(date_create($end_date), "d/M/Y")}}" />
                                             @endif
                                             <button type="submit" id="searchPeriod" class="btn btn-primary mt-2"><i class="fas fa-search mr-2"></i>ค้นหา</button>
                                        </div>
                                   </form>
                              </div>
                         </div>
                         @foreach ($currencies as $currency)
                             <div class="card">
                                  <div class="card-header">
                                       <img src="{{asset('assets/images/currency/' . $currency->image)}}" style="width: 25px;">
                                       <h5>{{$currency->name}}</h5>
                                  </div>
                                  <div class="card-body">
                                       <div class="dt-responsive table-responsive">
                                            <table id="table{{$currency->id}}" class="table table-striped table-bordered nowrap">
                                                 <thead>
                                                      <tr>
                                                           <th class="border-top-0">No.</th>
                                                           <th class="border-top-0">Company</th>
                                                           <th class="border-top-0">Created by</th>
                                                           <th class="border-top-0">Order Date</th>
                                                           <th class="border-top-0">Order No</th>
                                                           <th class="border-top-0">Product sku</th>
                                                           <th class="border-top-0">Product name</th>
                                                           <th class="border-top-0">Quantity</th>
                                                           <th class="border-top-0">Product price</th>
                                                           <th class="text-center border-top-0">Total amount</th>
                                                      </tr>
                                                 </thead>
                                                 <tbody>
                                                      @php
                                                      $i = 1;
                                                      $total_quantity = 0;
                                                      $total_product_price = 0;
                                                      $total_amount = 0;
                                                      @endphp
                                                      @foreach ($products as $product)
                                                           @php
                                                           $last_product_id = "";
                                                           @endphp
                                                           @foreach ($product->OrderProduct as $order_product)
                                                                @if ($order_product->Order->currency_id == $currency->id)
                                                                     @if ($last_product_id != $order_product->product_id)
                                                                          <tr>
                                                                               <td>{{ $i }}</td>
                                                                               <td>{{ $product->Company->name }}</td>
                                                                               <td>{{ $order_product->CreatedBy->name }} {{ $order_product->CreatedBy->lastname }}</td>
                                                                               <td>{{ date_format($order_product->Order->created_at, 'd M Y') }}</td>
                                                                               <td>{{ $order_product->Order->order_no }}</td>
                                                                               <td>{{ ($order_product->Product->sku) }}</td>
                                                                               <td>{{ ($order_product->Product->name) }}</td>
                                                                               <td class="text-right">{{ ($order_product->pieces) }}</td>
                                                                               @php
                                                                                    $total_quantity = $total_quantity + $order_product->pieces;
                                                                               @endphp
                                                                               @if ($currency->id == 1)
                                                                                    <td class="text-right">{{ number_format($order_product->price_bath, 2) }}</td>
                                                                                    <td class="text-right">{{ number_format($order_product->price_bath * $order_product->pieces, 2) }}</td>
                                                                                    @php
                                                                                         $total_product_price = $total_product_price + $order_product->price_bath;
                                                                                         $total_amount = $total_amount + $order_product->price_bath * $order_product->pieces;
                                                                                    @endphp
                                                                               @elseif ($currency->id == 2)
                                                                                    <td class="text-right">{{ number_format($order_product->price_lak, 2) }}</td>
                                                                                    <td class="text-right">{{ number_format($order_product->price_lak * $order_product->pieces, 2) }}</td>
                                                                                    @php
                                                                                         $total_product_price = $total_product_price + $order_product->price_lak;
                                                                                         $total_amount = $total_amount + $order_product->price_lak * $order_product->pieces;
                                                                                    @endphp
                                                                               @elseif ($currency->id == 3)
                                                                                    <td class="text-right">{{ number_format($order_product->price_usd, 2) }}</td>
                                                                                    <td class="text-right">{{ number_format($order_product->price_usd * $order_product->pieces, 2) }}</td>
                                                                                    @php
                                                                                         $total_product_price = $total_product_price + $order_product->price_usd;
                                                                                         $total_amount = $total_amount + $order_product->price_usd * $order_product->pieces;
                                                                                    @endphp
                                                                               @elseif ($currency->id == 4)
                                                                                    <td class="text-right">{{ number_format($order_product->price_khr, 2) }}</td>
                                                                                    <td class="text-right">{{ number_format($order_product->price_khr * $order_product->pieces, 2) }}</td>
                                                                                    @php
                                                                                         $total_product_price = $total_product_price + $order_product->price_khr;
                                                                                         $total_amount = $total_amount + $order_product->price_khr * $order_product->pieces;
                                                                                    @endphp
                                                                               @endif
                                                                          </tr>
                                                                          @php
                                                                          $i++;
                                                                          $last_product_id = $order_product->product_id;
                                                                          @endphp
                                                                     @endif
                                                                @endif
                                                           @endforeach
                                                      @endforeach
                                                 </tbody>
                                                 <tfoot>
                                                      <tr>
                                                           <td colspan="7"></td>
                                                           <td class="text-right">{{ $total_quantity }}</td>
                                                           <td class="text-right">{{ number_format($total_product_price, 2) }}</td>
                                                           <td class="text-right">{{ number_format($total_amount, 2) }}</td>
                                                      </tr>
                                                 </tfoot>
                                            </table>
                                       </div>
                                  </div>
                             </div>
                        @endforeach
                    </div>
               </div>
          </div>
     </div>
@endsection
@section('modal')

@endsection
@section('js_bottom')
     <!-- datatable Js -->
     <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>

     <!-- datepicker js -->
     <script src="{{asset('assets/js/plugins/moment.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/daterangepicker.js')}}"></script>

     <script type="text/javascript">
     $(document).ready(function() {

          $(function() {
               $('input[name="daterange"]').daterangepicker({
                    locale: {
                         format: 'DD MMM YYYY'
                    },

                    opens: 'left'
               }, function(start, end, label) {

               });
          });

          $("#pcoded").pcodedmenu({
               themelayout: 'horizontal',
               MenuTrigger: 'hover',
               SubMenuTrigger: 'hover',
          });

          $("#company_id").change(function(e) {
               e.preventDefault();
               $.ajax({
                    method : "POST",
                    url : '{{ route('report.get_member') }}',
                    dataType : 'json',
                    data : {"company_id" : $(this).val()},
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                         $(".preloader").css("display", "block");
                    },
               }).done(function(rec){
                    $("#preloaders").css("display", "none");
                    $('#user_id').empty();
                    if (rec.status == 1){
                         if ((rec.users).length > 0){
                              $('#user_id').append($('<option>', {
                                   value: "",
                                   text : "ทั้งหมด"
                              }));
                              $.each(rec.users, function (key, user) {
                                   $('#user_id').append($('<option>', {
                                        value: user.id,
                                        text : user.name + ' ' + user.lastname
                                   }));
                              });
                         }
                    }
               }).fail(function(){
                    $("#preloaders").css("display", "none");
                    swal("", rec.content, "error");
               });
          });


     });
     </script>
@endsection
