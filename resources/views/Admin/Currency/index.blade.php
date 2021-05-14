@extends('layouts.layout')
@section('css_bottom')
@endsection
@section('body')
     <div class="row">
         <div class="col-sm-12">
             <div class="card">
                 <div class="card-header">
                    <h5>ปรับค่าเงินกีบ</h5>
                 </div>
                 <div class="card-body">
                      <div class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                     <div class="modal-header">
                                          <h5 class="modal-title h4" id="mySmallModalLabel">ปรับค่าเงินกีบ</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                     </div>
                                     <div class="modal-body">
                                          <div class="row">
                                               <div class="form-group form-inline">
                                                    <label>1 THB = </label>
                                                    <input type="text" class="ml-2 form-control" name="lak" value="{{$lak->exchange_rate}}">LAK
                                               </div>
                                          </div>
                                     </div>
                                     <div class="modal-body">
                                     
                                     </div>
                                </div>
                           </div>
                      </div>
                      <div class="row">
                           <div class="col-md-6 col-xl-3">
                                <div class="card bg-c-red">
                                     <div class="card-body">
                                          <h5 class="text-white">
                                               <img height="28" width="32" src="{{asset('assets/images/laos.png')}}">
                                          </h5>
                                          <h5 class="text-white">LAK<span class="float-right">{{number_format(300.42, 2)}} = 1THB</span></h6>
                                          <div class="text-center">
                                               <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fas fa-cog"></i></button>
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
