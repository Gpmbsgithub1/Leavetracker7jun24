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
                                    <h1>Viral Mafia</h1>
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
                        <li><a href="{{route('hr.awards')}}" class="active"><i class="material-icons md-light">star</i> Awards</a></li>
                        <li><a href="{{route('hr.expense')}}"><i class="material-icons md-light">account_balance_wallet</i> Expense</a></li>
                        <li><a href="{{route('hr.holiday')}}"><i class="material-icons md-light">holiday_village</i> Holiday</a></li>
                    </ul>
                </div>
                <div class="zeynep">
                    <ul>
                        <li><a class="top_menuactive" href="{{route('hr.home')}}"><i class="material-icons md-light">dashboard</i>Dashboard</a></li>



                        <li class="has-submenu">
                            <a href="{{route('hr.employees')}}" data-submenu="stores"><i class="material-icons md-light">person</i>Employee</a>

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
                                    <li><a href="{{route('hr.add_award')}}"><i class="material-icons">publish</i> Add Award</a></li>
                                    <li><a href="{{route('hr.awards')}}" class="active"><i class="material-icons">folder</i> Awards</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-10 pr-0 pl-0">
                            <div class="dash-right-wrap">
                                <div class="row">
                                    <div class="col-lg-4 col-xl-6 col-md-3">
                                        <h2 class="page-head">Uploaded Documents</h2>
                                    </div>
                                    <div class="col-lg-8 col-xl-6 col-md-9">

                                    </div>
                                    <div class="col-lg-12 col-xl-12">
                                        <div class="responsive-block d-lg-none">
                                            <div class="row">
                                                <!-- item -->
                                                <div class="col-12 col-md-6">
                                                    <div class="card p-4">
                                                        <div class="dropdown dropleft">
                                                            <a class="btn p-0 dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="material-icons">more_vert</i>
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item" href="#">View</a>
                                                                <a class="dropdown-item" href="#">Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                        <span><b>Document Name</b></span>
                                                        <span class="sub">Salary Slip</span>
                                                        <span><b>Emp ID</b></span>
                                                        <span class="sub">Sk003</span>
                                                        <span><b>Name</b></span>
                                                        <span class="sub">Krishnajith K</span>
                                                        <span><b>Description</b></span>
                                                        <span class="sub">Embed the icon font in your site and learn how to style your icons using CSS</span>

                                                    </div>
                                                </div>
                                                <!-- item -->
                                                <!-- item -->
                                                <div class="col-12 col-md-6">
                                                    <div class="card p-4">
                                                        <div class="dropdown dropleft">
                                                            <a class="btn p-0 dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="material-icons">more_vert</i>
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item" href="#">View</a>
                                                                <a class="dropdown-item" href="#">Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-sm">Delete</a>
                                                            </div>
                                                        </div>
                                                        <span><b>Document Name</b></span>
                                                        <span class="sub">Salary Slip</span>
                                                        <span><b>Emp ID</b></span>
                                                        <span class="sub">Sk003</span>
                                                        <span><b>Name</b></span>
                                                        <span class="sub">Krishnajith K</span>
                                                        <span><b>Description</b></span>
                                                        <span class="sub">Embed the icon font in your site and learn how to style your icons using CSS</span>

                                                    </div>
                                                </div>
                                                <!-- item -->
                                            </div>
                                        </div>
                                        <div class="table-list">

                                            <div class="card d-none d-lg-block">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>

                                                            <th scope="col">#</th>
                                                            <th scope="col">Award Name</th>
                                                            <th scope="col">Emp ID</th>
                                                            <th scope="col">Name</th>

                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($awd->count())
                                                        @foreach($awd as $k => $docs)
                                                        <tr>

                                                            <th scope="row">{{++$i}}</th>
                                                            <td>{{$docs->award_name}}</td>
                                                            @if($docs->employee=='all')
                                                            <td>All</td>
                                                            @else
                                                            <td>{{@$awd[$k]->user->employee_id}}</td>
                                                            @endif
                                                            @if($docs->employee=='all')
                                                            <td>All</td>
                                                            @else
                                                            <td>{{@$awd[$k]->user->name}}</td>
                                                            @endif



                                                            <td>
                                                                <div class="dropdown dropleft">
                                                                    <a class="btn p-0 dropdown-toggle " href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="material-icons">more_vert</i>
                                                                    </a>

                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                        <a class="dropdown-item" href="{{route('hr.view_award', $docs->id)}}">View</a>
                                                                        <a class="dropdown-item" href="{{route('hr.edit_award', $docs->id)}}">Edit</a>
                                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-sm-{{$docs->id}}">Delete</a>
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
                                        {!! $awd->appends(request()->query())->links() !!}
                                    </div>
                                </div>
                            </div>

                            <span class="powered">Copyright © {{date('Y')}} Leave Tracker, All rights reserved. Powered by <a href="https://gpmbs.com/" target="_blank">GPMBS</a></span>


                        </div>
                    </div>
                </div>
            </div>

            @foreach($awd as $k => $docs)
            <!-- delete modal -->
            <div class="modal fade bd-example-modal-sm-{{$docs->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content p-4">
                        <i class="material-icons md-light red">delete</i>
                        <span class="content">Do you really want to delete ?</span>
                        <div class="button-holder">

                            <button class="btn btn-cancel mt-4 fils mr-3" data-dismiss="modal"><span>Cancel</span></button>
                            <a class="btn btn-default mt-4 filz" href="{{route('hr.delete_award', $docs->id)}}"><span>Delete</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- delete modal -->
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
