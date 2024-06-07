<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<style type="text/css">
  .form-section .invalid-feedback {
    display: block;
    position: relative;
    font-size: 11px;
    color: #d0332f !important;
    left: 0 !important;
    animation: slide-up-fade-in ease 1s;
    font-weight: 500;
    margin-top: 10px !important;
    margin-bottom: 10px;
    text-align: left;
}
</style>
</head>
<body>
  <!-- hyrbee -->
<div class="lv-automation">
  <div class="auth">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-7 gradient-bg d-none d-lg-block">
        <div class="large-img-wrap">
        <img width="600" class="img-fluid" src="{{asset('content/img/register.svg')}}" />
      </div>
      </div>
      <div class="col-lg-5">
        <div class="form-section">
          <h1>Leave Tracker</h1>
          <span class="sub-title">Register an account</span>
          <form method="POST" action="{{ route('register') }}">
            @csrf
             <div class="form-group">
               <label >Name <span class="required-icon" title="This field is required."></span></label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('name')}}
                 </span>
                @endif
             </div>
              <div class="form-group">
               <label >Company <span class="required-icon" title="This field is required."></span></label>
                <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}">
                @if ($errors->has('company'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('company')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Employee ID <span class="required-icon" title="This field is required."></span></label>
                <input id="employee_id" type="text" class="form-control" name="employee_id" value="{{ old('employee_id') }}">
                @if ($errors->has('employee_id'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('employee_id')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Email <span class="required-icon" title="This field is required."></span></label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('email')}}
                 </span>
                @endif
             </div>
              <div class="form-group">
               <label >Phone <span class="required-icon" title="This field is required."></span></label>
                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}"> 
                @if ($errors->has('phone'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('phone')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Password <span class="required-icon" title="This field is required."></span></label>
                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                <a class="eye-icon"><i class="material-icons md-light">visibility</i></a>
                <a class="eye-slash-icon"><i class="material-icons md-light">visibility_off</i></a>
                @if ($errors->has('password'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('password')}}
                 </span>
                @endif
             </div>
             <button type="submit" class="btn btn-default w-100 mt-3 mb-4 filz"><span>Register</span></button>
          </form>
          <span>
            <a href="{{route('login')}}" class="link">Already Registered ? Sign In</a>
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
