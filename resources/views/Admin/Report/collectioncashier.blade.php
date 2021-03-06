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
                                   <form action="{{ route('report.collectioncashier') }}" method="GET" role="search">
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
                                                           <th class="text-center border-top-0">No.</th>
                                                           <th class="text-center border-top-0">Company</th>
                                                           <th class="text-center border-top-0">Order Date</th>
                                                           <th class="text-center border-top-0">Order No</th>
                                                           <th class="text-center border-top-0">COD</th>
                                                           <th class="text-center border-top-0">Customer<br/>Mobile No.</th>
                                                           <th class="text-center border-top-0">Invoice<br/>Amount</th>
                                                           <th class="text-center border-top-0">Collect<br/>Amount</th>
                                                           <th class="text-center border-top-0">Delivery<br/>Charges</th>
                                                           <th class="text-center border-top-0">Other<br/>Charges</th>
                                                           <th class="text-center border-top-0">Total<br/>Charges</th>
                                                           <th class="text-center border-top-0">Discount<br/>Amount</th>
                                                           <th class="text-center border-top-0">Name<br/>CreateInfo</th>
                                                           <th class="text-center border-top-0">Remark</th>
                                                      </tr>
                                                 </thead>
                                                 <tbody>
                                                      @php
                                                           $cnt = 1;
                                                           $total_all = 0;
                                                      @endphp
                                                      @foreach ($orders->where('currency_id', '=', $currency->id) as $order)
                                                           <tr>
                                                                <td class="text-center">{{ $cnt }}</td>
                                                                <td class="text-center">{{ $order->Company->name}}</td>
                                                                <td class="text-center">{{ $order->created_at}}</td>
                                                                <td class="text-center">{{ $order->order_no }}</td>
                                                                <td class="text-center">{{ isset($order->delivery) ? 'Yes' : 'No' }}</td>
                                                                <td class="text-center">{{ $order->customer_phone_number }}</td>
                                                                @if ($currency->id == 1)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_bath') + $order->OrderBoxs->sum('price_bath') + $order->shipping_cost + $order->delivery - $order->discount, 2) }}</td>
                                                                     @php
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_bath') + $order->OrderBoxs->sum('price_bath') + $order->shipping_cost + $order->delivery - $order->discount);
                                                                     @endphp
                                                                @elseif ($currency->id == 2)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_lak') + $order->OrderBoxs->sum('price_lak') + $order->shipping_cost + $order->delivery - $order->discount, 2) }}</td>
                                                                     @php
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_lak') + $order->OrderBoxs->sum('price_lak') + $order->shipping_cost + $order->delivery - $order->discount);
                                                                     @endphp
                                                                @elseif ($currency->id == 3)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_usd') + $order->OrderBoxs->sum('price_usd') + $order->shipping_cost + $order->delivery - $order->discount, 2) }}</td>
                                                                     @php
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_usd') + $order->OrderBoxs->sum('price_usd') + $order->shipping_cost + $order->delivery - $order->discount);
                                                                     @endphp
                                                                @elseif ($currency->id == 4)
                                                                     <td class="text-right">{{ number_format($order->OrderProduct->sum('price_khr') + $order->OrderBoxs->sum('price_khr') + $order->shipping_cost + $order->delivery - $order->discount, 2) }}</td>
                                                                     @php
                                                                          $total_all = $total_all + ($order->OrderProduct->sum('price_khr') + $order->OrderBoxs->sum('price_khr') + $order->shipping_cost + $order->delivery - $order->discount);
                                                                     @endphp
                                                                @endif
                                                                <td></td>
                                                                <td>{{ $order->shipping_cost }}</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>{{ $order->discount }}</td>
                                                                <td class="text-center">{{ $order->CreatedBy->name}} {{$order->CreatedBy->lastname}}</td>
                                                                <td>{{ $order->remark }}</td>
                                                           </tr>
                                                           @php
                                                                $cnt++;
                                                           @endphp
                                                      @endforeach
                                                 </tbody>
                                                 <tfoot>
                                                      <tr>
                                                           <td colspan="6"></td>
                                                           <td class="text-right">{{ $total_all }}</td>
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
