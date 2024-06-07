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
                                            <a class="dropdown-item" href="{{route('employee.change_password')}}">Change Password</a>
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
                                    <li><a href="#" class="active"><i class="material-icons">person</i> My Profile</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-10 pr-0 pl-0">
                            <div class="dash-right-wrap">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="page-head">My Profile</h2>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card p-4 profile">
                                            <div class="row">
                                                <div class="col-lg-1 profile-img col-md-12">
                                                    <i class="material-icons md-light">person</i>
                                                </div>
                                                <div class="col-lg-5 profile-info-left col-md-6">
                                                    <h6>{{$user->name}}</h6>
                                                    <span>{{$user->designation}}</span>
                                                    <ul class="pl-0 mb-0">
                                                        <li>
                                                            <span class="title">Emp ID :</span>
                                                            <span class="text">{{$user->employee_id}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Date of Join :</span>
                                                            <span class="text">{{date('d M Y', strtotime($user->joining_date))}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Company :</span>
                                                            <span class="text">{{$company->company_name}}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <ul class="mb-0">

                                                        <li>
                                                            <span class="title">Email :</span>
                                                            <span class="text">{{$user->email}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Phone :</span>
                                                            <span class="text">+91 {{$user->phone}}</span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Group :</span>
                                                            @if(count($member))
                                                            @foreach($member as $k => $members)
                                                            <span class="text">{{$member[$k]->grp->group_name}}</span>
                                                            @endforeach
                                                            @else
                                                            <span class="text">-- Nil --</span>
                                                            @endif
                                                        </li>
                                                        <li>
                                                        <span class="title">Reports To :</span>
                                                          @if(isset($g))
                                                            <span class="text">{{@$gm->name}}</span>
                                                          @elseif(isset($grp))
                                                            <span class="text">{{@$hr->name}}</span>
                                                          @elseif($user->groups==0)
                                                            <span class="text">{{@$hr->name}}</span>
                                                          @endif
                                                        </li>
                                                       
                                                    </ul>
                                                </div>
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
