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
    <li><a href="{{route('hr.home')}}" class="active"><i class="material-icons md-light">dashboard</i> Dashboard</a></li>
    <li><a href="{{route('hr.employees')}}"><i class="material-icons md-light">person</i> Employee</a></li>
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
                <a href="{{route('hr.create_employee')}}"><span class="plus-icon"></span> Create Employee</a>
              </li>
               <li> <a href="{{route('hr.employees')}}">Employees</a>   </li>
               <li> <a href="{{route('hr.inactive_employees')}}">Inactive Employees</a>   </li>
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
                <a href="{{route('hr.create_group')}}">Create Group</a></a>
              </li>

              <li>
                <a href="{{route('hr.groups')}}">Groups</a>
              </li>

             
            </ul>
          </div>
        </li>   
        <li class="has-submenu">
          <a href="#" data-submenu="stores2"><i class="material-icons md-light">holiday_village</i>Leave Request</a>

          <div id="stores2" class="submenu">
            <div class="submenu-header" data-submenu-close="stores2">
              <a href="#">Back</a>
            </div>

            <ul>
              <li>
                <a href="{{route('hr.leave_requests')}}"> Leave Request</a>
              </li>
               <li> <a href="{{route('hr.approved_leaves')}}" >Approved Leaves</a></li>
               <li> <a href="{{route('hr.rejected_leaves')}}" >Rejected Leaves</a></li>
            </ul>
          </div>
        </li>
        <li class="has-submenu">
          <a href="#" data-submenu="stores3"><i class="material-icons md-light">folder</i>Document</a>

          <div id="stores3" class="submenu">
            <div class="submenu-header" data-submenu-close="stores3">
              <a href="#">Back</a>
            </div>

            <ul>
              <li>
                <a href="{{route('hr.add_document')}}"><span class="plus-icon"></span> Upload Document</a>
              </li>
               <li> <a href="{{route('hr.documents')}}">Documents</a>   </li>
            </ul>
          </div>
        </li>
        <li><a href="data-bank.html"><i class="material-icons md-light">account_balance_wallet</i>Employee Salary</a></li>
        <li class="has-submenu">
          <a href="#" data-submenu="stores4"><i class="material-icons md-light">star</i>Awards</a>

          <div id="stores4" class="submenu">
            <div class="submenu-header" data-submenu-close="stores4">
              <a href="#">Back</a>
            </div>

            <ul>
              <li>
                <a href="{{route('hr.add_award')}}"><span class="plus-icon"></span> Add Award</a>
              </li>
               <li> <a href="{{route('hr.awards')}}">Awards</a>   </li>
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
      
      <div class="col-lg-12 pr-0 pl-0">
        <div class="dash-right-wrap main-dash">
        <div class="row">

       <div class="col-lg-4 col-md-5">
           <h2 class="page-head">Analytics</h2>
         <div class="row">
            <div class="col-lg-6 col-6">
              <a href="{{route('hr.employees')}}">
          <div class="card p-4 anl">
            <i class="material-icons md-light bl-gradient">person</i>
            <span>Employees</span>
            <h5>{{$employee}}</h5>
          </div>
        </a>
        </div>
        <div class="col-lg-6 col-6">
          <a href="{{route('hr.groups')}}">
          <div class="card p-4 anl">
            <i class="material-icons md-light rd-gradient">people</i>
            <span>Groups</span>
             <h5>{{$group}}</h5>
          </div>
        </a>
        </div>
        <div class="col-lg-12">
            <!-- responsive-block -->
<div class="responsive-block d-lg-none">
   <h2 class="page-head">Employees On Leave Today
 <span class="float-right">
               <a href="#"><i class="material-icons">arrow_right_alt</i></a>
             </span>
             </h2>
    
<div class="card p-4">
<span><b>Emp ID</b></span>
<span class="sub">Sk001</span>
<span><b>Name</b></span>
<span class="sub">Krishnajith K</span>
<span><b>Leave Type</b></span>
<span class="sub">Casual Leave</span>
</div>

  
</div>
  <!-- responsive-block end -->

          <div class="d-none d-lg-block">
             <h2 class="page-head">Employees On Leave Today
 <span class="float-right">
               <a href="{{route('hr.approved_leaves')}}">View All</a>
             </span>
             </h2>
            
             <div class="card ">
             <table class="table table-hover mb-0">
  <thead>
    <tr>
      <th scope="col">EmpID</th>
      <th scope="col">Name</th>
      <th scope="col">Leave Type</th>
    </tr>
  </thead>
  <tbody>
    @if($leave->count())
    @foreach($leave->take(5) as $k => $leaves)
    <tr>
      <th scope="row">{{$leaves->employee_id}}</th>
      <td>{{$leave[$k]->user->name}}</td>
      <td>{{$leaves->leave_type}}</td>
    </tr>
    @endforeach
    @else
    <tr>

      <td class="empty-table" colspan="10">
        <div class="empty-data">
          <img width="100" class="img-fluid mx-auto d-block pb-3" src="{{asset('content/img/nothing.svg')}}" />
          <h5>Nothing to show at this time</h5>
        </div>
      </td>
    </tr>
    @endif
  </tbody>
</table>
 </div>
           </div>
      </div>
         </div>
       </div>
       <div class="col-lg-8 col-md-7">
        <!-- responsive-block -->
<div class="responsive-block d-lg-none">
<h2 class="page-head">Leave Request
 <span class="float-right">
               <a href="#"><i class="material-icons">arrow_right_alt</i></a>
             </span>
             </h2>
    
<div class="card p-4">
<span><b>Emp ID</b></span>
<span class="sub">Sk001</span>
<span><b>Name</b></span>
<span class="sub">Krishnajith K</span>
<span><b>Leave Type</b></span>
<span class="sub">Casual Leave</span>
<span><b>Duration</b></span>
<span class="sub">01/05/2021 to 01/05/2021</span>
<span><b>Reason</b></span>
<span class="sub">Personal Program</span>
<div class="button-holder">
                <button type="submit" class="btn btn-default mt-4 filz w-100" data-toggle="modal" data-target=".bd-example-modal-smr"><span>Reject</span></button>
             <button type="submit" class="btn btn-cancel mt-4 fils w-100"><span>Approve</span></button>
           </div>
</div>

<h2 class="page-head">Newly Joined Employees
 <span class="float-right">
               <a href="#"><i class="material-icons">arrow_right_alt</i></a>
             </span>
             </h2>
<div class="card p-4">
  <div class="dropdown dropleft">
       <a class="btn p-0 dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="material-icons">more_vert</i>
       </a>
       <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
       <a class="dropdown-item" href="#">View</a>
       <a class="dropdown-item" href="#">Edit</a>
       </div>
        </div>
<span><b>Emp ID</b></span>
<span class="sub">Sk001</span>
<span><b>Joining Date</b></span>
<span class="sub">01/05/2021</span>
<span><b>Name</b></span>
<span class="sub">Krishnajith K</span>
<span><b>Email</b></span>
<span class="sub">  krishnajith@skilora.in</span>
<span><b>Phone</b></span>
<span class="sub">+91 97476 33769</span>


</div>

   </div>
   <!-- responsive-block end -->       
         <div class="d-none d-lg-block">
         <h2 class="page-head">Leave Request
 <span class="float-right">
               <a href="{{route('hr.leave_requests')}}">View All</a>
             </span>
             </h2>
         <div class="card ">
             <table class="table table-hover mb-0">
  <thead>
    <tr>
      <th scope="col">EmpID</th>
      <th scope="col">Name</th>
      <th scope="col">Leave Type</th>
      <th scope="col">Day(s)</th>
      <th scope="col">Reason</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @if($request->count())
    @foreach($request->take(5) as $k => $requests)
    <tr>
      <th scope="row">{{$requests->employee_id}}</th>
      <td>{{$request[$k]->user->name}}</td>
      <td>{{$requests->leave_type}}</td>
      <td>{{@$requests->dates}}</td>
      <td>{{$requests->leave_reason}}</td>
      <td> <div class="dropdown dropleft">
       <a class="btn p-0 dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="material-icons">more_vert</i>
       </a>
       <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
       <a class="dropdown-item" href="{{route('hr.leave_accept', $requests->id)}}">Approve</a>
       <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-smr-{{$requests->id}}">Reject</a>
       </div>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>

      <td class="empty-table" colspan="10">
        <div class="empty-data">
          <img width="100" class="img-fluid mx-auto d-block pb-3" src="{{asset('content/img/nothing.svg')}}" />
          <h5>Nothing to show at this time</h5>
        </div>
      </td>
    </tr>
    @endif
  </tbody>
</table>
 </div>


<h2 class="page-head">Newly Joined Employees
 <span class="float-right">
               <a href="{{route('hr.employees')}}">View All</a>
             </span>
             </h2>
         <div class="card ">
             <table class="table table-hover mb-0">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Emp ID</th>
      <th scope="col">Joining Date</th>
       <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @if($emp->count())
    @foreach($emp->take(5) as $k => $emps)
    <tr>
       <th scope="row">{{++$i}}</th>
      <th >{{$emps->employee_id}}</th>
       <td>{{date('d M Y', strtotime($emps->joining_date))}}</td>
      @if($emps->hr==1)
      <td class="hr">{{$emps->name}}</td>
      @else
      <td>{{$emps->name}}</td>
      @endif

      <td>{{$emps->email}}</td>
      <td>+91 {{$emps->phone}}</td>
      <td> <div class="dropdown dropleft">
       <a class="btn p-0 dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="material-icons">more_vert</i>
       </a>
       <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
       <a class="dropdown-item" href="{{route('hr.edit_employee', $emps->id)}}">Edit</a>
       </div>
        </div>
      </td>
    </tr>
    @endforeach
    @else
    <tr>

      <td class="empty-table" colspan="10">
        <div class="empty-data">
          <img width="100" class="img-fluid mx-auto d-block pb-3" src="{{asset('content/img/nothing.svg')}}" />
          <h5>Nothing to show at this time</h5>
        </div>
      </td>
    </tr>
    @endif
  </tbody>
</table>
 </div>


       </div>
        </div>
      </div>
        </div>

<span class="powered">Copyright © {{date('Y')}} Leave Tracker, All rights reserved. Powered by <a href="https://gpmbs.com/" target="_blank">GPMBS</a></span>


      </div>
    </div>
  </div>
</div>
@foreach($request as $k => $requests)
            <!-- reject modal -->
            <div class="modal fade bd-example-modal-smr-{{$requests->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">

                    <div class="modal-content p-4">
                        <div class="modal-head mb-3">
                            <h5>Reject Leave Request</h5>
                        </div>
                        <form method="POST" action="{{route('hr.leave_reject', $requests->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Reason <span class="required-icon"></span></label>
                                <textarea class="form-control" name="reject_reason"></textarea>
                            </div>
                        <div class="button-holder">
                            <button type="submit" class="btn btn-default mt-3 filz mr-3" data-dismiss="modal"><span>Cancel</span></button>
                            <button type="submit" class="btn btn-cancel mt-3 fils "><span>Submit</span></a>

                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- reject modal -->
            @endforeach

@if ($message = Session::get('success'))
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
</body>
</html>
