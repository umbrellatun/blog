<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>{{ config('app.name', 'Laravel') }}</title>

     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="description" content="" />
     <meta name="keywords" content="">
     <meta name="author" content="Codedthemes" />
     <!-- Favicon icon -->
     <link rel="icon" href="{{ asset('assets/images/favicon.ico')}}" type="image/x-icon">

     <!-- vendor css -->
     <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
</head>
<body>
     <div class="auth-wrapper">
          <div class="auth-content">
               <div class="card">
                    <div class="row align-items-center text-center">
                         <div class="col-md-12">
                              <div class="card-body">
                                   <form id="FormLogin" role="form">
                                        <img src="{{asset('assets/images/logo-dark.png')}}" alt="" class="img-fluid mb-4">
                                        <h4 class="mb-3 f-w-400">Signin</h4>
                                        <div class="input-group mb-3">
                                             <div class="input-group-prepend">
                                                  <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                             </div>
                                             <input type="email" class="form-control" name="username" placeholder="Email address">
                                        </div>
                                        <div class="input-group mb-4">
                                             <div class="input-group-prepend">
                                                  <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                             </div>
                                             <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group text-left mt-2">
                                             <div class="checkbox checkbox-primary d-inline">
                                                  <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
                                                  <label for="checkbox-fill-a1" class="cr"> Save credentials</label>
                                             </div>
                                        </div>
                                        <button type="submit" class="btn btn-block btn-primary mb-4">SignIn</button>
                                   </form>

                                   <p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html" class="f-w-400">Reset</a></p>
                                   <p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html" class="f-w-400">Signup</a></p>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <!-- Required Js -->
     <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
     <script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
     <script src="{{asset('assets/js/waves.min.js')}}"></script>
     <!-- jQuery -->
     <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
     <!-- sweetalert2 -->
     <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

     <!-- sweet alert Js -->
     <script src="{{ asset('assets/js/plugins/sweetalert.min.js') }}"></script>
     <script>
     $.ajaxSetup({
          headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
     });
     $('body').on('submit','#FormLogin',function(e){
          e.preventDefault();
          $.ajax({
               method: "POST",
               url: "{{url('admin/CheckLogin')}}",
               data: $(this).serialize(),
               headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },
          }).done(function( res ) {
               if(res==0){
                    swal("", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!", "warning");
               }else{
                    window.location = "{{ route('dashboard')}}";
               }
          }).fail(function(){
               swal("", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!", "warning");
          });
     });
     </script>
</body>

</html>
