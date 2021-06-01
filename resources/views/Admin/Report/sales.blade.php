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
                         <h5>Report</h5>
                    </div>
                    <div class="card-body">
                         <h5 class="mb-3">{{$title}}</h5>
                         <div class="row">
                              <div class="col-md-12">
                                   <div class="form-group">
                                        <label class="form-label">บริษัท</label>
                                        <select class="form-control" name="company_id" id="company_id">
                                             <option value>กรุณาเลือก</option>
                                             @foreach ($companies as $company)
                                                  <option value="{{$company->id}}">{{$company->name}}</option>
                                             @endforeach
                                        </select>
                                   </div>
                                   <div class="form-group">
                                        <label class="form-label">ช่วงวันที่</label>
                                        <input type="text" name="daterange" id="daterange" class="form-control" value="{{date_format(date_create($start_date), "d/M/Y")}} - {{date_format(date_create($end_date), "d/M/Y")}}" />
                                        <button type="submit" id="searchPeriod" class="btn btn-primary mt-2"><i class="fas fa-search mr-2"></i>ค้นหา</button>
                                   </div>
                              </div>
                         </div>
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


     });
     </script>
@endsection
