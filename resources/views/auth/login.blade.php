<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Leave Tracker</title>
    <!-- CSS -->
     <link rel="icon" href="{{asset('content/img/fav.png')}}" type="image/gif" sizes="32x32">
    <link rel="stylesheet" href="{{asset('content/css/bootstrap.min.css')}}" type="text/css">
     <link href="{{asset('content/css/latofont.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('content/css/_lv_automation.css')}}" type=" text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--     <link rel="stylesheet" href="content/css/intlTelInput.css"> -->
</head>
<body>
  <!-- hyrbee -->
<div class="lv-automation">
  <div class="auth">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-7 gradient-bg d-none d-lg-block">
        <div class="large-img-wrap">
        <img width="550" class="img-fluid" src="{{asset('content/img/signin.svg')}}" />
      </div>
      </div>
      <div class="col-lg-5">
        <div class="form-section">
          <h1>Leave Tracker</h1>
          <span class="sub-title">Welcome back, Sign in to continue</span>
          <form method="POST" action="{{ route('login') }}">
                        @csrf
             <div class="form-group">
               <label >User Name <span class="required-icon"></span></label>
                <input id="employee_id" type="employee_id" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}" required autocomplete="employee_id" maxlength="10" autofocus>

                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
								
								 
             </div>
             <div class="form-group">
               <label >Password <span class="required-icon"></span></label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <a class="eye-icon"><i class="material-icons md-light">visibility</i></a>
                <a class="eye-slash-icon"><i class="material-icons md-light">visibility_off</i></a>
                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
             </div>
             <div class="form-group custom-checkbox">
                <input id="box-1" name="remember" type="checkbox" /> 
                <label for="box-1">Remember me</label>
             </div>
             <button type="submit" class="btn btn-default w-100 mt-3 mb-4 filz"><span>Sign In</span></button>
          </form>
          <span>
            <a href="" class="link">Forgot Password ?</a>
            <!-- <a href="{{route('register')}}" class="link float-right">Register ?</a> -->
          </span>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
  <!-- hyrbee end-->
<footer>
            
</footer>

<!-- jQuery plugins -->
<script src="{{asset('scripts/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('scripts/popper.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap.min.js')}}"></script>  
<!-- <script src="scripts/intlTelInput.min.js"></script> -->
 <script type="text/javascript">
    $(".eye-icon").click(function() {
      $(this).toggleClass("slash")
      $(".eye-slash-icon").addClass("active")

      var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
});
    $(".eye-slash-icon").click(function() {
 $(this).removeClass("active")
 $(".eye-icon").removeClass("slash")
 var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      });
  </script>

</body>
</html>
