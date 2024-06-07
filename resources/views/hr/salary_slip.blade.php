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
                        <li><a href="{{route('hr.home')}}"><i class="material-icons md-light">dashboard</i> Dashboard</a></li>
                        <li><a href="{{route('hr.employees')}}"><i class="material-icons md-light">person</i> Employee</a></li>
                        <li><a href="{{route('hr.groups')}}"><i class="material-icons md-light">people</i> Groups</a></li>
                        <li><a href="{{route('hr.leave_requests')}}"><i class="material-icons md-light">holiday_village</i> Leave Request</a></li>
                        <li><a href="{{route('hr.documents')}}"><i class="material-icons md-light">folder</i> Document</a></li>
                        @if(date('m')>=25 && date('m')<=31)
                        <li title="This link will be enabled next month"><a href="{{route('hr.salary')}}" style="pointer-events: none"><i class="material-icons md-light">account_balance_wallet</i> Employee Salary</a></li>
                        @else
                        <li><a href="{{route('hr.salary')}}" id="salary" class="active"><i class="material-icons md-light">account_balance_wallet</i> Employee Salary</a></li>
                        @endif
                        <li><a href="{{route('hr.awards')}}"><i class="material-icons md-light">star</i> Awards</a></li>
                        <li><a href="{{route('hr.expense')}}"><i class="material-icons md-light">account_balance_wallet</i> Expense</a></li>
                        <li><a href="{{route('hr.holiday')}}"><i class="material-icons md-light">holiday_village</i> Holiday</a></li>
                    </ul>
                </div>
                <div class="zeynep">
                    <ul>
                        <li><a class="top_menuactive" href="company-dashboard.html"><i class="material-icons md-light">dashboard</i>Dashboard</a></li>



                        <li class="has-submenu">
                            <a href="#" data-submenu="stores"><i class="material-icons md-light">person</i>Employee</a>

                            <div id="stores" class="submenu">
                                <div class="submenu-header" data-submenu-close="stores">
                                    <a href="#">Back</a>
                                </div>

                                <ul>
                                    <li>
                                        <a href="user-creation1.html"><span class="plus-icon"></span> Create Employee</a></a>
                                    </li>
                                    <li> <a href="manage-user.html" class="active">Employees</a> </li>
                                    <li> <a href="manage-user.html" class="active">Inactive Employees</a> </li>
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

                                    <li><a href="{{route('hr.salary')}}" class="active"><i class="material-icons">person</i> Employee Salary</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-10 pr-0 pl-0">
                            <div class="dash-right-wrap">
                                <div class="row">
                                    <div class="col-lg-12 col-xl-6 col-md-12">
                                        <h2 class="page-head">Employee Salary - {{$employee->name}} - Salary Slip</h2>
                                    </div>
                                 
                                    <div class="col-lg-12 col-xl-12">
                                        
                                        <div class="salary-slip">
 <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="{{asset('content/img/gpmbslogo.jpg')}}" style="width: 100%; max-width: 100px" />
                                </td>
                                <td align="right">
                                   {{date('F')}} {{date('d')}} , {{date('Y')}}<br />
                                   Kozhikode
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td style="width: 350px;">
                                  00, 1st floor, SK complex ,<br> SK temple rd, Near SK temple , <br>Kozhikode-673004
                                </td>

                                <td style="width: 300px;">
                                   <b>{{date('M Y')}}</b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

             
                <tr class="information">
                    <td colspan="4">
                        <table>
                            <tr class="boarder-btm">
                                <td><b>Employee ID</b></td>
                                <td>: {{$employee->employee_id}}</td>
                                <td><b>Name</b></td>
                                <td>: {{$employee->name}}</td>
                            </tr>
                             <tr class="boarder-btm">
                                <td><b>Date of Joining</b></td>
                                <td>: {{date('F d, Y', strtotime($employee->joining_date))}}</td>
                                <td><b>Pay Date</b></td>
                                <td>: {{date('F')}} 25, {{date('Y')}}</td>
                            </tr>
                             <tr class="boarder-btm">
                                <td><b>No.of Working Days</b></td>
                                <td>: 30</td>
                                <td><b>No.of Leaves Taken(LOP)</b></td>
                                <td>: {{$paid}}</td>
                            </tr>
                            <tr style="height: 50px;">
                                <td><b>Days Worked</b></td>
                                <td>: {{$worked}}</td>
                                <td><b>Total Leaves Taken</b></td>
                                <td>: {{$days}}</td>
                            </tr>
                        </table>

                    </td>

                </tr>
<tr class="heading">
       <td>Earnings</td>
       <td>Amount</td> 
       <td>Deduction</td>           
</tr>
   <tr class="boarder-btm">
       <td>Basic Salary</td>
       <td>{{@$employee->basic_salary}}</td> 
       <td></td>           
</tr>           
  <tr class="boarder-btm">
       <td>HRA</td>
       <td>{{@$employee->hra}}</td> 
       <td></td>           
</tr> 
  <tr class="boarder-btm">
       <td>Other Allowence</td>
       <td>{{@$basic}}</td> 
       <td>{{@$ded}}</td>           
</tr>            
  <tr style="height: 50px;">
       <td>Salary Advance</td>
       <td></td> 
       <td>{{@$employee->salary_advance}}</td>           
</tr>
  <tr class="heading" >
       <td>Total Earnings</td>
       <td>{{$earn}}</td> 
       <td>{{@$totded}}</td>           
</tr>            
   <tr>
       <td style="height: 20px;"></td>  
   </tr> 
   <tr>
       <td>*This is a computer generated payslip | No Signature Required*</td>  
   </tr>            
              
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

            <!-- add to salary modal -->
            <div class="modal fade " id="sal-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog ">

                    <div class="modal-content p-4">
                        <div class="modal-head mb-3">
                            <h5>Add Staff Salary</h5>
                        </div>
                        <form>
                            <div class="form-group">
                                <label>Month <span class="required-icon"></span></label>

                                <input class="date form-control" id='datetimepicker'>
                                <div><i style="float: right;margin-top: -32px;margin-right: 15px !important;" class="material-icons mr-2">calendar_today</i></div>
                            </div>
                            <div class="form-group">
                                <label>Group <span class="required-icon"></span></label>
                                <select class="form-control w-100 custom">
                  <option>Tech</option>
                  <option>Product</option>
                </select>
                            </div>
                            <div class="form-group">
                                <label>Employee <span class="required-icon"></span></label>
                                <select class="form-control w-100 custom">
                  <option>Shahabas</option>
                  <option>Midhun</option>
                </select>
                            </div>
                            <div class="form-group">
                                <label>Basic Salary <span class="required-icon"></span></label>
                                <input class="form-control" />
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Working Days <span class="required-icon"></span></label>
                                        <input class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Worked Days <span class="required-icon"></span></label>
                                        <input class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Leave Taken <span class="required-icon"></span></label>
                                        <input class="form-control" readonly value="5" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Leave Deduction <span class="required-icon"></span></label>
                                        <input class="form-control" readonly value="1500" />
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="button-holder">
                            <button type="submit" class="btn btn-default mt-3 filz mr-3" data-dismiss="modal"><span>Cancel</span></button>
                            <button type="submit" class="btn btn-cancel mt-3 fils "><span>Submit</span></button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- add to salary modal -->
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
    <script src="{{asset('scripts/moment.min.js')}}"></script>
    <script src="{{asset('scripts/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $('#datetimepicker').datetimepicker({
            defaultDate: new Date(),
            format: 'DD/MM/YYYY',
            sideBySide: true
        });
        $('#datetimepicker1').datetimepicker({
            defaultDate: new Date(),
            format: 'DD/MM/YYYY',
            sideBySide: true
        });
    </script>
    <script>
        jQuery(document).ready(function($) {
            $(window).load(function() {
                $('#preloader').fadeOut('slow', function() {
                    $(this).remove();
                });
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
    <script>
        $('input:checkbox').change(function() {
            if ($(this).is(":checked")) {
                $('.action-pannel').addClass("active");
            } else {
                $('.action-pannel').removeClass("active");
            }
        });
    </script>
</body>

</html>
