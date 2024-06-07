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
     <link rel="stylesheet" href="{{asset('content/css/mobile-nav.css')}}" type=" text/css">
     <link rel="stylesheet" href="{{asset('content/css/custom-select.css')}}" type=" text/css">
     <link rel="stylesheet" href="{{asset('content/css/bootstrap-datepicker.min.css')}}" type=" text/css">
     <style type="text/css">
       .user-name{
        color: white;
       }
     </style>
</head>
<body class="grey-bg">
    <div id="preloader">
        <div class="loader">
         <img width="30" class="img-fluid d-block mx-auto mt-2" src="{{asset('content/img/loader.svg')}}" />
        </div>
        </div>
  <!-- hyrbee -->
<div class="lv-automation">
  <div class="dashboard">
<header>
  <div class="top-nav gradient-bg">
    <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 col-8">
        <div class="menu btn-open d-lg-none">
          <i class="material-icons">menu</i></div>
        <a href="{{route('employee.home')}}" class="logo">
        <h1>{{$company->company_name}}</h1>
      </a>
      </div>
    
      <div class="col-lg-6 col-4">
        <ul class="top-right-nav float-right mb-0">
      
          <li class="nav-item dropdown show user-info">
  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="user-name">{{auth()->user()->name}}</span>
   <span class="user-icon">
   <i class="material-icons md-light">account_circle</i>
   </span>
  </a>

  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="{{route('employee.profile')}}">Profile</a>
    <a class="dropdown-item active" href="{{route('employee.change_password')}}">Change Password</a>
    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                            <span class="sign-out-icon"></span>Sign Out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
  </div>

          </li>
        </ul>
      </div>
    </div>
    </div>
  </div>
<div class="main-navigation d-lg-block d-none">
  <ul class="mb-0">
    <li><a href="{{route('employee.home')}}"><i class="material-icons md-light">dashboard</i> Dashboard</a></li>

    <li><a href="{{route('employee.leaves')}}"><i class="material-icons md-light">holiday_village</i> Leave Info</a></li>
    <li><a href="{{route('employee.documents')}}"><i class="material-icons md-light">folder</i> Documents</a></li>
    @if(isset($grp))
    <li><a href="{{route('employee.groups')}}"><i class="material-icons md-light">people</i> Groups</a></li>
    @endif
    <li><a href="{{route('employee.holidays')}}"><i class="material-icons md-light">holiday_village</i> Holiday</a></li>
  </ul>
</div>
<div class="zeynep">
                <ul>
    <li><a class="top_menuactive" href="company-dashboard.html"><i class="material-icons md-light">dashboard</i>Dashboard</a></li>



         <li class="has-submenu">
          <a href="#" data-submenu="stores1"><i class="material-icons md-light">holiday_village</i>Leave Request</a>

          <div id="stores1" class="submenu">
            <div class="submenu-header" data-submenu-close="stores1">
              <a href="#">Back</a>
            </div>

            <ul>
               <li>
                <a href="plan-creation.html">Request Leave</a></a>
              </li>

              <li>
                <a href="manage-plan.html">Applied</a>
              </li>
<li>
                <a href="manage-plan.html">Approved</a>
              </li>
             <li>
                <a href="manage-plan.html">Rejected</a>
              </li>
            </ul>
          </div>
        </li>  
                </ul>
            </div>
            <div class="zeynep-overlay"></div>


</header>
<div class="main-wrap">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2">
        <div class="side-bar d-lg-block d-none">
          <ul>
            <li><a href="#" class="active"><i class="material-icons">add_circle</i> Change Password</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-10 pr-0 pl-0">
        <div class="dash-right-wrap">
        <div class="row">
          <div class="col-lg-2 col-xl-3"></div>
          <div class="col-lg-8 col-xl-6">
            <div class="card mt-3 mb-3">
              <h3 class="form-head">Change Password</h3>
              <div class="form-wrap">
                <form method="POST" id="leave_form" action="{{ route('employee.change_password.store') }}" enctype="multipart/form-data">
                        @csrf
                  <input type="hidden" name="pass" value="{{$user->pass}}">
             <div class="form-group">
               <label >Old Password <span class="required-icon"></span></label>
                <input type="Password" id="old_password" name="old_password" value="{{ old('old_password') }}" class="form-control" placeholder="Old Password" aria-label="Password" aria-describedby="password-addon">
                <a class="eye-icon"><i class="material-icons md-light">visibility</i></a>
                <a class="eye-slash-icon"><i class="material-icons md-light">visibility_off</i></a>
                @if ($errors->has('old_password'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('old_password')}}
                 </span>
                @endif
             </div>

             <div class="form-group">
               <label >New Password <span class="required-icon"></span></label>
                <input type="Password" id="new_password" name="new_password" value="{{ old('new_password') }}" class="form-control" placeholder="New Password" aria-label="Password" aria-describedby="password-addon">
                <a class="eye-icon2"><i class="material-icons md-light">visibility</i></a>
                <a class="eye-slash-icon2"><i class="material-icons md-light">visibility_off</i></a>
                @if ($errors->has('new_password'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('new_password')}}
                 </span>
                @endif
             </div>

             <div class="form-group">
               <label >Confirm Password <span class="required-icon"></span></label>
                <input type="Password" id="confirm_password" name="confirm_password" value="{{ old('confirm_password') }}" class="form-control" placeholder="Confirm Password" aria-label="Password" aria-describedby="password-addon">
                <a class="eye-icon3"><i class="material-icons md-light">visibility</i></a>
                <a class="eye-slash-icon3"><i class="material-icons md-light">visibility_off</i></a>
                @if ($errors->has('confirm_password'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('confirm_password')}}
                 </span>
                @endif
             </div>
             
             <div class="button-holder">
                <a href="{{route('employee.home')}}" class="btn btn-default mt-4 filz mr-3"><span>Cancel</span></a>
             <button type="submit" class="btn btn-cancel mt-4 fils"><span>Submit</span></button>
           </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-xl-3"></div>
        </div>
        </div>

<span class="powered">Copyright © {{date('Y')}} Leave Tracker, All rights reserved. Powered by <a href="https://gpmbs.com/" target="_blank">GPMBS</a></span>


      </div>
    </div>
  </div>
</div>

@if ($message = Session::get('error'))
<div class="success-message">
  <i class="material-icons md-light green">done</i>
  <span>{{$message}}</span>
</div>
@endif


  </div>
</div>
  <!-- hyrbee end-->
<footer>
            
</footer>

<!-- jQuery plugins -->
<script src="{{asset('scripts/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('scripts/popper.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap.min.js')}}"></script> 
<script src="{{asset('scripts/jquery.zeynep.min.js')}}"></script>
<script src="{{asset('scripts/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('scripts/fastclick.js')}}"></script>
<script src="{{asset('scripts/moment.min.js')}}"></script>
<script src="{{asset('scripts/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
  var casual = $('#leave_type').val();
  if (casual=='casual_leave') {
    $('#casual').show();
  }
  if (casual=='medical_leave') {
    $('#medical_leave').show();
  }
  if (casual=='paternity_leave') {
    $('#paternity_leave').show();
  }
  if (casual=='maternity_leave') {
    $('#maternity_leave').show();
  }
  if (casual=='bereavement_leave') {
    $('#bereavement_leave').show();
  }
  if (casual=='comp_off') {
    $('#comp_off').show();
  }
  $(function() {
        $('#leave_type').change(function(){
            $('.leaves').hide();
            $('#' + $(this).val()).show();

            var lt = $('#leave_type').val();
            var days = $('#days').val();
            var d = new Date();
            var ml = $('#ml').val();

            if (lt=='casual_leave' && days>2) {
              // alert(d);
              $('#casual').show();
              $('#casual_warning').show();
            }

            if (lt=='casual_leave' && days<=2) {
              // alert(d);
              $('#casual').hide();
              $('#casual_warning').hide();
            }

            if (lt!='casual_leave') {
              // alert("Yes");
              $('#casual_warning').hide();
            }

            if (lt=='medical_leave' && $days>ml) {
              
            }
        });
    });
</script>
<script type="text/javascript">
// $('#datetimepicker1').on('dp.change', function(e){
//   var start = $('.start').val();
//   var end = $('.end').val();
//   var days = daysdifference(start, end)+1;
  
//   // console.log(days);
//   $('#days').val(days);
  
//   function daysdifference(firstDate, secondDate){
//       var startDay = new Date(firstDate);
//       var endDay = new Date(secondDate);
     
//       var millisBetween = startDay.getTime() - endDay.getTime();
//       var days = millisBetween / (1000 * 3600 * 24);
     
//       return Math.round(Math.abs(days));
//   }

//       var lt = $('#leave_type').val();
//       var days = $('#days').val();

//       if (lt=='casual_leave' && days<3) {
//               // alert(d);
//               $('#casual').hide();
//               $('#casual_warning').hide();
//             }
// });
</script>
<!-- <script type="text/javascript">
$('.form-group').on('input', '.dat', function(){
  var start = #(.start).val();
  var end = #(.end).val();
   
var days = daysdifference(start, end);
$('#days').val(days);
  
console.log(days);
  
function daysdifference(firstDate, secondDate){
    var startDay = new Date(firstDate);
    var endDay = new Date(secondDate);
   
    var millisBetween = startDay.getTime() - endDay.getTime();
    var days = millisBetween / (1000 * 3600 * 24);
   
    return Math.round(Math.abs(days));
}
});
</script> -->
 <script>
      jQuery(document).ready(function($) {  
      $(window).load(function(){
      $('#preloader').fadeOut('slow',function(){$(this).remove();});
      });
      });
      </script>  
 <script type="text/javascript">
    $(".eye-icon").click(function() {
      $(this).toggleClass("slash")
      $(".eye-slash-icon").addClass("active")

      var x = document.getElementById("old_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
});
    $(".eye-slash-icon").click(function() {
 $(this).removeClass("active")
 $(".eye-icon").removeClass("slash")
 var x = document.getElementById("old_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      });
  </script>
  <script type="text/javascript">
    $(".eye-icon2").click(function() {
      $(this).toggleClass("slash")
      $(".eye-slash-icon2").addClass("active")

      var x = document.getElementById("new_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
});
    $(".eye-slash-icon2").click(function() {
 $(this).removeClass("active")
 $(".eye-icon2").removeClass("slash")
 var x = document.getElementById("new_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      });
  </script>
  <script type="text/javascript">
    $(".eye-icon3").click(function() {
      $(this).toggleClass("slash")
      $(".eye-slash-icon3").addClass("active")

      var x = document.getElementById("confirm_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
});
    $(".eye-slash-icon3").click(function() {
 $(this).removeClass("active")
 $(".eye-icon3").removeClass("slash")
 var x = document.getElementById("confirm_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      });
  </script>
  <script>
        $(function() {
            // init zeynepjs
            var zeynep = $('.zeynep').zeynep({
                onClosed: function() {
                    // enable main wrapper element clicks on any its children element
                    $("body main").attr("style", "");

                    console.log('the side menu is closed.');
                },
                onOpened: function() {
                    // disable main wrapper element clicks on any its children element
                    $("body main").attr("style", "pointer-events: none;");

                    console.log('the side menu is opened.');
                }
            });

            // handle zeynep overlay click
            $(".zeynep-overlay").click(function() {
                zeynep.close();
            });

            // open side menu if the button is clicked
            $(".btn-open").click(function() {
                if ($("html").hasClass("zeynep-opened")) {
                    zeynep.close();
                } else {
                    zeynep.open();
                }
            });
        });
    </script>
      <script>
    $(document).ready(function() {
      $('select.custom:not(.ignore)').niceSelect();      
      FastClick.attach(document.body);
    });    
  </script>
</body>
</html>
