<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Leave Tracker</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('content/css/bootstrap.min.css')}}" type="text/css">
    <link href="{{asset('content/css/latofont.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('content/css/_lv_automation.css')}}" type=" text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('content/css/mobile-nav.css')}}" type=" text/css">
    <link rel="stylesheet" href="{{asset('content/css/custom-select.css')}}" type=" text/css">
    <link rel="stylesheet" href="{{asset('content/css/datepicker.css')}}" type=" text/css">
</head>

<body class="grey-bg">
    <!-- hyrbee -->
    <div class="lv-automation">
        <div class="dashboard">
                                 
                                    <div class="col-lg-12 col-xl-12">
                                        
                                        <div class="salary-slip">
 <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="https://leavetrack.skiloratech.com/content/img/logodark.png" style="width: 100%; max-width: 100px" />
                                </td>
                                <td align="right">
                                   {{date('F d')}}, {{date('Y')}}<br />
                                   Calicut
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td>
                                   Skilora Technologies, 2nd Floor,<br> UL Cyberpark, Nellikode. P.O, <br>Calicut, Kerala, India
                                </td>

                                <td>
                                   {{$salary_month}}
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
                                <td>: {{$empl->employee_id}}</td>
                                <td><b>Name</b></td>
                                <td>: {{$empl->name}}</td>
                            </tr>
                             <tr class="boarder-btm">
                                <td><b>Date of Joining</b></td>
                                <td>: {{date('F d, Y', strtotime($empl->joining_date))}}</td>
                                <td><b>Pay Date</b></td>
                                <td>: {{date('F')}} 25, {{date('Y')}}</td>
                            </tr>
                             <tr class="boarder-btm">
                                <td><b>No.of Working Days</b></td>
                                <td>: 30</td>
                                <td><b>LOP</b></td>
                                <td>: 0</td>
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
       <td>YTD</td>           
</tr>
   <tr class="boarder-btm">
       <td>Basic Salary</td>
       <td>{{@$empl->basic_salary}}</td> 
       <td></td>           
</tr>           
  <tr class="boarder-btm">
       <td>HRA</td>
       <td>{{@$empl->hra}}</td> 
       <td></td>           
</tr> 
  <tr class="boarder-btm">
       <td>Other Allowence</td>
       <td>0</td> 
       <td></td>           
</tr>            
  <tr style="height: 50px;">
       <td>Salary Advance</td>
       <td></td> 
       <td>{{@$empl->salary_advance}}</td>           
</tr>
  <tr class="heading" >
       <td>Total Earnings</td>
       <td>{{$earn}}</td> 
       <td>0</td>           
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