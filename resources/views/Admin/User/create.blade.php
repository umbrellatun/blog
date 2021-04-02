@extends('layouts.layout')
<link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
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
                                       <h5 class="m-b-10">{{$titie}}</h5>
                                   </div>
                                   <ul class="breadcrumb">
                                       <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="feather icon-home"></i></a></li>
                                       <li class="breadcrumb-item"><a href="{{route('user')}}">สมาชิกทั้งหมด</a></li>
                                       <li class="breadcrumb-item">{{$titie}}</li>
                                   </ul>
                              </div>
                           </div>
                       </div>
                   </div>
                   <!-- [ breadcrumb ] end -->
                    <div class="row">
                         <div class="col-lg-12">
                              <div class="card">
                                  <div class="card-body">
                                      <form id="validation-form123" action="#!">
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Email</label>
                                                      <input type="text" class="form-control" name="validation-email" placeholder="Email">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">ชื่อ</label>
                                                      <input type="text" class="form-control" name="validation-required" placeholder="Required">
                                                  </div>

                                              </div>
                                              <div class="col-md-6">
                                                   <div class="form-group">
                                                      <label class="form-label">Password</label>
                                                      <input type="password" class="form-control" name="validation-password" placeholder="Password">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">URL</label>
                                                      <input type="text" class="form-control" name="validation-url" placeholder="Url">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Confirm password</label>
                                                      <input type="password" class="form-control" name="validation-password-confirmation" placeholder="Confirm password">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Phone</label>
                                                      <input type="text" class="form-control" name="validation-phone" placeholder="Phone: (999) 999-9999">
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Select</label>
                                                      <select class="form-control" name="validation-select">
                                                          <option value>Select gear...</option>
                                                          <optgroup label="Climbing">
                                                              <option value="pitons">Pitons</option>
                                                              <option value="cams">Cams</option>
                                                              <option value="nuts">Nuts</option>
                                                              <option value="bolts">Bolts</option>
                                                              <option value="stoppers">Stoppers</option>
                                                              <option value="sling">Sling</option>
                                                          </optgroup>
                                                          <optgroup label="Skiing">
                                                              <option value="skis">Skis</option>
                                                              <option value="skins">Skins</option>
                                                              <option value="poles">Poles</option>
                                                          </optgroup>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Text</label>
                                                      <textarea class="form-control" name="validation-text"></textarea>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">File</label>
                                                      <div>
                                                          <input type="file" class="validation-file" name="validation-file">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <div class="switch d-inline m-r-10">
                                                          <input type="checkbox" class="switcher-input" name="validation-switcher" id="switch-1">
                                                          <label for="switch-1" class="cr"></label>
                                                      </div>
                                                      <label>Check me</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Radios</label>
                                                      <div class="form-check">
                                                          <label class="form-check-label">
                                                              <input class="form-check-input" type="radio" name="validation-radios"> Option one is this and that—be sure to include why it's great
                                                          </label>
                                                      </div>
                                                      <div class="form-check">
                                                          <label class="form-check-label">
                                                              <input class="form-check-input" type="radio" name="validation-radios"> Option two can be something else and selecting it will deselect option one
                                                          </label>
                                                      </div>
                                                      <div class="form-check disabled">
                                                          <label class="form-check-label">
                                                              <input class="form-check-input" type="radio" name="validation-radios"> Option three is disabled
                                                          </label>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Custom radios</label>
                                                      <div class="custom-controls-stacked">
                                                          <label class="custom-control custom-radio">
                                                              <input name="validation-radios-custom" type="radio" class="custom-control-input">
                                                              <span class="custom-control-label">Option one is this and that—be sure to include why it's great</span>
                                                          </label>
                                                          <label class="custom-control custom-radio">
                                                              <input name="validation-radios-custom" type="radio" class="custom-control-input">
                                                              <span class="custom-control-label">Option two can be something else and selecting it will deselect option one</span>
                                                          </label>
                                                          <label class="custom-control custom-radio">
                                                              <input name="validation-radios-custom" type="radio" class="custom-control-input">
                                                              <span class="custom-control-label">Option three is disabled</span>
                                                          </label>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Checkbox</label>
                                                      <div class="form-check">
                                                          <label class="form-check-label">
                                                              <input class="form-check-input" type="checkbox" name="validation-checkbox"> Check me out
                                                          </label>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-group">
                                                      <label class="form-label">Custom checkbox</label>
                                                      <br>
                                                      <label class="custom-control custom-checkbox d-block">
                                                          <input type="checkbox" class="custom-control-input" name="validation-checkbox-custom">
                                                          <span class="custom-control-label">Check me</span>
                                                      </label>
                                                  </div>
                                              </div>
                                          </div>
                                          <button type="submit" class="btn  btn-primary">Submit</button>
                                      </form>
                                  </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
@endsection
@section('js_bottom')
     <!-- datatable Js -->
     <script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>

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

         $('#FormAdd').validate({
             errorElement: 'div',
             errorClass: 'invalid-feedback',
             focusInvalid: false,
             rules: {
                 name :{
                     required: true,
                 },
             },
             messages: {
                 name :{
                     required: "กรุณาระบุ",
                 },
             },
             highlight: function (e) {
                 validate_highlight(e);
             },
             success: function (e) {
                 validate_success(e);
             },
             errorPlacement: function (error, element) {
                 validate_errorplacement(error, element);
             },
             submitHandler: function (form) {
                 var btn = $("#FormAdd").find('[type="submit"]');
                 btn.button("loading");
                 $.ajax({
                     method : "POST",
                     url : '{{ route('user.store') }}',
                     dataType : 'json',
                     data : $("#FormAdd").serialize(),
                     headers: {
                          'X-CSRF-TOKEN': "{{ csrf_token() }}"
                     }
                 }).done(function(rec){
                     btn.button("reset");
                     if (rec.status == 1) {
                          swal("", rec.content, "success").then(function(){
                               window.location.href = "{{ route('menu') }}";
                          });
                     } else {
                          swal("", rec.content, "warning");
                     }
                 }).fail(function(){
                     btn.button("reset");
                 });
             },
             invalidHandler: function (form) {

             }
         });

     </script>
@endsection
