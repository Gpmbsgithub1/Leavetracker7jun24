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
                        <li><a href="{{route('hr.salary')}}" id="salary"><i class="material-icons md-light">account_balance_wallet</i> Employee Salary</a></li>
                        @endif
                        <li><a href="{{route('hr.awards')}}"><i class="material-icons md-light">star</i> Awards</a></li>
                        <li><a href="{{route('hr.expense')}}"><i class="material-icons md-light">account_balance_wallet</i> Expense</a></li>
                        <li><a href="{{route('hr.holiday')}}"><i class="material-icons md-light">holiday_village</i> Holiday</a></li>
                    </ul>
                </div>
                <div class="zeynep">
                    <ul>
                        <li><a href="company-dashboard.html"><i class="material-icons md-light">dashboard</i>Dashboard</a></li>



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
                                    <li><a href="#"><i class="material-icons">add_circle</i> Create Employee</a></li>
                                    <li><a href="#" class="active"><i class="material-icons">person</i> Employees</a></li>
                                    <li><a href="#"><i class="material-icons">person_off</i> Inactive Employees</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-10 pr-0 pl-0">
                            <div class="dash-right-wrap">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="page-head">Profile - {{@$user->name}}</h2>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card p-4 profile">
                                            <div class="row">
                                                <div class="col-lg-1 profile-img col-md-12">
                                                    <i class="material-icons md-light">person</i>
                                                </div>
                                                <div class="col-lg-5 profile-info-left col-md-6">
                                                    <h6>{{@$user->name}}</h6>
                                                    <span>{{@$user->designation}}</span>
                                                    <ul class="pl-0 mb-0">
                                                        <li>
                                                            <span class="title">Emp ID :</span>
                                                            <span class="text">{{@$user->employee_id}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Date of Join :</span>
                                                            <span class="text">{{date('d M Y', strtotime($user->joining_date))}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Company :</span>
                                                            <span class="text">{{@$company->company_name}}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <ul class="mb-0">

                                                        <li>
                                                            <span class="title">Email :</span>
                                                            <span class="text">{{@$user->email}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Phone :</span>
                                                            <span class="text">+91 {{@$user->phone}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Group :</span>
                                                            @if($grp!='')
                                                            <span class="text">{{@$grp->group_name}}</span>
                                                            @else
                                                            <span class="text">-Nil-</span>
                                                            @endif
                                                        </li>
                                                        <li>
                                                            <span class="title">Reports To :</span>
                                                            @if(count($manager)>0)
                                                            @foreach($manager as $k => $managers)
                                                            <span class="text">{{$manager[$k]->us->name}}</span>
                                                            @endforeach
                                                            @else
                                                            <span class="text">{{auth()->user()->name}}</span>
                                                            @endif

                                                        </li>
                                                        <li>
                                                            <span class="title">Working Status :</span>
                                                            @if($user->status == 1)
                                                            <span class="text">Active</span>
                                                            @elseif($user->status == 0)
                                                            <span class="text">Inactive</span>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="page-head pt-0">Generate Pay Slip - {{date('F Y')}}</h2>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="responsive-block d-lg-none">
                                            <div class="card p-4">
                                                <span><b>Working Days</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Holidays</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Worked Days</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Leave Taken</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Sarary</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Leave Deduction</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Total Earnings</b></span>
                                                <span class="sub">25</span>
                                                <button type="submit" class="btn btn-default mt-4 filz "><span>Generate</span></button>
                                            </div>
                                        </div>
                                        <div class="d-none d-lg-block">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>


                                                        <th scope="col">Working Days</th>
                                                        <th scope="col">Worked Days</th>
                                                        <th scope="col">Leave Taken</th>
                                                        <th scope="col">Earned Leaves</th>
                                                        <th scope="col">Loss of pay</th>
                                                        <th scope="col">Salary</th>
                                                        <th scope="col">Leave Deduction</th>
                                                        <th scope="col">Total Earnings</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                        <td>30</td>
                                                        <td>{{$worked}}</td>
                                                        <td>{{$days}}</td>
                                                        <td>{{$free}}</td>
                                                        <td>{{$paid}}</td>
                                                        <td>{{$user->base_salary}}</td>
                                                        <td>{{$ded}}</td>
                                                        <td>{{$earn}}</td>
                                                        <td>
                                                            <a href="{{route('hr.salary_slip', $user->employee_id)}}" class="btn btn-cancel fils"><span>Generate</span></a>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h2 class="page-head pt-1">Leave Summary</h2>
                                    </div>
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card p-4">
                                            <form>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>From Date <span class="required-icon"></span></label>

                                                            <input class="date form-control" id='datetimepicker'>
                                                            <div><i style="float: right;margin-top: -32px;margin-right: 15px !important;" class="material-icons mr-2">calendar_today</i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Upto Date <span class="required-icon"></span></label>

                                                            <input class="date form-control" id='datetimepicker1'>
                                                            <div><i style="float: right;margin-top: -32px;margin-right: 15px !important;" class="material-icons mr-2">calendar_today</i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3"><button type="submit" class="btn btn-default mt-4 filz "><span>Search</span></button> </div>
                                                    <div class="col-lg-3"></div>
                                                </div>
                                            </form>


                                        </div>

                                        <div class="responsive-block d-lg-none">
                                            <div class="card p-4">
                                                <span><b>Month</b></span>
                                                <span class="sub">January</span>
                                                <span><b>Working Days</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Holidays</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Worked Days</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Leave Taken</b></span>
                                                <span class="sub">25</span>
                                                <span><b>Remaining</b></span>
                                                <span class="sub">25</span>

                                            </div>
                                        </div>

                                        <div class="d-none d-lg-block">


                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>

                                                        <th scope="col">#</th>
                                                        <th scope="col">Month</th>
                                                        <th scope="col">Working Days</th>
                                                        <th scope="col">Holidays</th>
                                                        <th scope="col">Worked Days</th>
                                                        <th scope="col">Leave Taken</th>
                                                        <th scope="col">Remaning</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                        <th scope="row">1</th>
                                                        <td>January</td>
                                                        <td>25</td>
                                                        <td>2</td>
                                                        <td>20</td>
                                                        <td>3</td>
                                                        <td>3</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="empty-data">
                                            <img width="100" class="img-fluid mx-auto d-block pb-3" src="{{asset('content/img/nothing.svg')}}" />
                                            <h5>Nothing to show at this time</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <span class="powered">Copyright © {{date('Y')}} Leave Tracker, All rights reserved. Powered by <a href="https://gpmbs.com/" target="_blank">GPMBS</a></span>

                        </div>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
            <div class="success-message">
                <i class="material-icons md-light green">done</i>
                <span>Group created successfully</span>
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
</body>

</html>
