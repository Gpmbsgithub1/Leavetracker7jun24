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
     <link rel="stylesheet" href="{{asset('content/css/datepicker.css')}}" type=" text/css">
     <link rel="stylesheet" href="{{asset('content/css/jquery-ui.css')}}" type=" text/css">
     <style type="text/css">
       .user-name{
        color: white;
       }
     </style>
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

        i.custom-button-previous:before {
          content: "<<";
      }

        i.custom-button-next:before {
          content: ">>";
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
        <a href="{{route('hr.home')}}" class="logo">
        <h1>{{auth()->user()->company}}</h1>
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
    <a class="dropdown-item" href="{{route('hr.change_password')}}">Change Password</a>
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
    <li><a href="{{route('hr.home')}}"><i class="material-icons md-light">dashboard</i> Dashboard</a></li>
    <li><a href="{{route('hr.employees')}}" class="active"><i class="material-icons md-light">person</i> Employee</a></li>
    <li><a href="{{route('hr.groups')}}"><i class="material-icons md-light">people</i> Groups</a></li>
    <li><a href="{{route('hr.leave_requests')}}"><i class="material-icons md-light">holiday_village</i> Leave Request</a></li>
    <li><a href="{{route('hr.documents')}}"><i class="material-icons md-light">folder</i> Document</a></li>
    @if(date('m')>=25 && date('m')<=31)
    <li title="This link will be enabled next month"><a href="{{route('hr.salary')}}" style="pointer-events: none"><i class="material-icons md-light">account_balance_wallet</i> Employee Salary</a></li>
    @else
    <li><a href="{{route('hr.salary')}}" id="salary"><i class="material-icons md-light">account_balance_wallet</i> Employee Salary</a></li>
    @endif
    <li><a href="{{route('hr.awards')}}"><i class="material-icons md-light">star</i> Awards</a></li>
    <li><a href="{{route('hr.expense')}}"><i class="material-icons md-light">account_balance_wallet</i> Expense</a></li>
    <li><a href="{{route('hr.holiday')}}"><i class="material-icons md-light">holiday_village</i> Holiday</a></li>
  </ul>
</div>
<div class="zeynep">
                <ul>
    <li><a class="top_menuactive" href="{{route('hr.home')}}"><i class="material-icons md-light">dashboard</i>Dashboard</a></li>



<li class="has-submenu">
          <a href="#" data-submenu="stores"><i class="material-icons md-light">person</i>Employee</a>

          <div id="stores" class="submenu">
            <div class="submenu-header" data-submenu-close="stores">
              <a href="#">Back</a>
            </div>

            <ul>
              <li>
                <a href="{{route('hr.create_employee')}}"><span class="plus-icon"></span> Create Employee</a></a>
              </li>
               <li> <a href="{{route('hr.employees')}}" class="active">Employees</a>   </li>
               <li> <a href="{{route('hr.inactive_employees')}}" class="active">Inactive Employees</a>   </li>
            </ul>
          </div>
        </li>
         <li class="has-submenu">
          <a href="#" data-submenu="stores1"><i class="material-icons md-light">people</i>Groups</a>

          <div id="stores1" class="submenu">
            <div class="submenu-header" data-submenu-close="stores1">
              <a href="#">Back</a>
            </div>

            <ul>
               <li>
                <a href="plan-creation.html">Create Group</a></a>
              </li>

              <li>
                <a href="manage-plan.html">Groups</a>
              </li>

             
            </ul>
          </div>
        </li>
<li><a href="data-bank.html"><i class="material-icons md-light">holiday_village</i>Leave Request</a></li>   
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
            <li><a href="{{route('hr.create_employee')}}" class="active"><i class="material-icons">add_circle</i> Create Employee</a></li>
             <li><a href="{{route('hr.employees')}}"><i class="material-icons">person</i> Employees</a></li>
             <li><a href="{{route('hr.inactive_employees')}}"><i class="material-icons">person_off</i> Inactive Employees</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-10 pr-0 pl-0">
        <div class="dash-right-wrap">
        <div class="row">
          <div class="col-lg-2 col-xl-3"></div>
          <div class="col-lg-8 col-xl-6">
            <div class="card mt-3 mb-3">
              <h3 class="form-head">Create Employee</h3>
              <div class="form-wrap">
                <form method="POST" id="employee_form" action="{{ route('hr.create_employee_store') }}" enctype="multipart/form-data">
                        @csrf
             <div class="form-group">
               <label >Name <span class="required-icon"></span></label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('name')}}
                 </span>
                @endif
             </div>
             <!-- <div class="form-group">
               <label >Company <span class="required-icon"></span></label>
                <input id="company" class="form-control">
             </div> -->
             <div class="form-group">
               <label >Employee ID <span class="required-icon"></span></label>
                <input id="employee_id" type="text" class="form-control" name="employee_id" value="{{ ++$eid }}">
                @if ($errors->has('employee_id'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('employee_id')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
              <label>Joining Date <span class="required-icon"></span></label> 
           
              <input class="date form-control" id='datetimepicker' name="joining_date">
              <div><i style="float: right;margin-top: -30px;margin-right: 15px !important;" class="material-icons mr-2">calendar_today</i></div>
                @if ($errors->has('joining_date'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('joining_date')}}
                 </span>
                @endif
             </div>

             <div class="form-group">
               <label >Designation <span class="required-icon"></span></label>
                <input id="designation" type="text" class="form-control" name="designation" value="{{ old('designation') }}">
                @if ($errors->has('designation'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('designation')}}
                 </span>
                @endif
             </div>

             <div class="form-group">
               <label >Employment Type <span class="required-icon"></span></label>
                <select class="form-control w-100 custom" name="employment_type">
                  <option>Select Employment Type</option>
                  <option value="contract" @if(old('employment_type')=='contract') selected @endif>Contract</option>
                  <option value="permanent" @if(old('employment_type')=='permanent') selected @endif>Permanent</option>
                </select>
                @if ($errors->has('employment_type'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('employment_type')}}
                 </span>
                @endif
            </div>

             <!-- form-group-->
<div class="form-group row ">
                                <div class="col-md-12">
                                    <label>Gender <span class="required-icon"></span></label>
                            <div class="form-check form-check-inline" >
                                <input class="form-check-input" type="radio" name="gender" value="M" @if(old('gender')=='M') checked @endif>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="F" @if(old('gender')=='F') checked @endif>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                                </div>

                          @if ($errors->has('gender'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('gender')}}
                 </span>
                @endif

                        </div>
<!-- form-group end-->

             <div class="form-group">
               <label >Email <span class="required-icon"></span></label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >
                @if ($errors->has('email'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('email')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Alternate Email <span class="required-icon"></span></label>
                <input id="alternate_email" type="email" class="form-control" name="alternate_email" value="{{ old('alternate_email') }}" >
                @if ($errors->has('alternate_email'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('alternate_email')}}
                 </span>
                @endif
             </div>
              <div class="form-group">
               <label >Phone Number <span class="required-icon"></span></label>
                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" >
                @if ($errors->has('phone'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('phone')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Emergency Contact Number(Alternate Phone Number) <span class="required-icon"></span></label>
                <input id="alternate_phone" type="text" class="form-control" name="alternate_phone" value="{{ old('alternate_phone') }}" >
                @if ($errors->has('alternate_phone'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('alternate_phone')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Address <span class="required-icon"></span></label>
                <textarea rows="4" id="address" type="text" class="form-control" name="address" >{{ old('address') }}</textarea>
                @if ($errors->has('address'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('address')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
              <label>Date of Birth <span class="required-icon"></span></label> 
           
              <input class="date form-control" id='birthdatepicker' name="birth_day" value="{{ old('birth_day') }}">
              <div><i style="float: right;margin-top: -30px;margin-right: 15px !important;" class="material-icons mr-2">calendar_today</i></div>
                @if ($errors->has('birth_day'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('birth_day')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
              <label>Wedding Date </label> 
           
              <input class="date form-control" id='weddingdatepicker' name="wedding_day" value="{{ old('wedding_day') }}">
              <div><i style="float: right;margin-top: -30px;margin-right: 15px !important;" class="material-icons mr-2">calendar_today</i></div>
                @if ($errors->has('wedding_day'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('wedding_day')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Bank Account Details <span class="required-icon"></span></label>
                <textarea rows="4" id="bank_account" type="text" class="form-control" name="bank_account" >{{ old('bank_account') }}</textarea>
                @if ($errors->has('bank_account'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('bank_account')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Basic Salary <span class="required-icon"></span></label>
                <input id="basic_salary" type="number" class="form-control sal" name="basic_salary" value="{{ old('basic_salary') }}" >
                @if ($errors->has('basic_salary'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('basic_salary')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >HRA <span class="required-icon"></span></label>
                <input id="hra" type="number" class="form-control sal" name="hra" value="{{ old('hra') }}" >
                @if ($errors->has('hra'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('hra')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Other Allowances <span class="required-icon"></span></label>
                <input id="other_allow" type="number" class="form-control sal" name="other_allow" value="{{ old('other_allow') }}" >
                @if ($errors->has('other_allow'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('other_allow')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label>Total Salary <span class="required-icon"></span></label>
                <input id="base_salary" type="text" class="form-control" name="base_salary" value="{{ old('base_salary') }}" readonly>
                @if ($errors->has('base_salary'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('base_salary')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Salary Advance(if any) </label>
                <input id="salary_advance" type="text" class="form-control" name="salary_advance" value="{{ old('salary_advance') }}" >
                @if ($errors->has('salary_advance'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('salary_advance')}}
                 </span>
                @endif
             </div>
             <div class="form-group">
               <label >Password <span class="required-icon"></span></label>
                <input id="password" type="password" class="form-control" name="password" value="">
                <a class="eye-icon"><i class="material-icons md-light">visibility</i></a>
                <a class="eye-slash-icon"><i class="material-icons md-light">visibility_off</i></a>
                @if ($errors->has('password'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('password')}}
                 </span>
                @endif
             </div>
            <div class="form-group">
               <label >Working Status <span class="required-icon"></span></label>
                <select class="form-control w-100 custom" name="status">
                  <option>Select Working Status</option>
                  <option value="1" @if(old('status')=='1') selected @endif>Active</option>
                  <option value="0" @if(old('status')=='0') selected @endif>Inactive</option>
                </select>
                @if ($errors->has('status'))
                 <span class="invalid-feedback" role="alert">
                 {{$errors->first('status')}}
                 </span>
                @endif
            </div>
            <div class="form-group">
              <label>Identity Proof <span class="required-icon"></span></label>
                <div class="field" align="left">
                  <span>
                    <input type="file" id="idp" name="idp" multiple accept=".pdf,.jpg,.png,.jpeg,.gif" />
                  </span>
                </div>
                @if ($errors->has('idp'))
                  <span class="invalid-feedback" role="alert">
                    {{$errors->first('idp')}}
                  </span>
                @endif
            </div>
            <div class="form-group">
              <label>PAN Card <span class="required-icon"></span></label>
                <div class="field" align="left">
                  <span>
                    <input type="file" id="pan" name="pan"  multiple accept=".pdf,.jpg,.png,.jpeg,.gif" />
                  </span>
                </div>
                @if ($errors->has('pan'))
                  <span class="invalid-feedback" role="alert">
                    {{$errors->first('pan')}}
                  </span>
                @endif
            </div>
             <div class="button-holder">
                <a href="{{route('hr.employees')}}" class="btn btn-default mt-4 filz mr-3"><span>Cancel</span></a>
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
<script src="{{asset('scripts/bootstrap-datetimepicker.min.js')}}"></script>
 <script>
      jQuery(document).ready(function($) {  
      $(window).load(function(){
      $('#preloader').fadeOut('slow',function(){$(this).remove();});
      });
      });
      </script>
      <script type="text/javascript">
        $('.form-group').on('input', '.sal', function(){
          var totalSum = 0;
          $('.form-group .sal').each(function(){
            var inputVal = $(this).val();
            if($.isNumeric(inputVal)){
              totalSum += parseFloat(inputVal);
            }
          });
          $('#base_salary').val(totalSum);
        });
      </script>  
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
  <script>
  $('#datetimepicker').datetimepicker({
    defaultDate: new Date(),
    format: 'MM/DD/YYYY',
    sideBySide: true,
});

  $('#birthdatepicker').datetimepicker({
    defaultDate: new Date(),
    maxDate: new Date(),
    format: 'MM/DD/YYYY',
    sideBySide: true,
});

  $('#weddingdatepicker').datetimepicker({
    format: 'MM/DD/YYYY',
    sideBySide: true,
});

</script>
<script type="text/javascript">
  var total = $('#base_salary').val();
  var basic = $('#basic_salary').val();
  var hra = $('#hra').val();
</script>

</body>
</html>
