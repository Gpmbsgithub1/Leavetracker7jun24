<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <style>
        /* table{
            border-spacing: -1px;
        } */
        /* td {
    border-color: #000000;
    border-style: solid;
    border-width: 1px;
} */
    </style>
</head>

<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style=" margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
	background-color: #FFFFFF;
	color: #000000;" bgcolor="#FFFFFF" text="#000000">
    <table class="table table-bordered" width="700" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: auto; padding: 0; border: 1px solid #000;margin-top: 30px;width: 700px; margin-bottom: 30px;">
        <tbody>
            <tr>
                <td>
                    <img style="width: 100px;" src="https://leavetrack.skiloratech.com/content/img/skilora.png" />
                </td>
                <td>
                    <span style="font-family: sans-serif;text-align:center;display: block;font-size: 15px;line-height: 20px;">Skilora Technologies<br>2nd Floor UL Cyberpark<br>Nellikode. P.O, Calicut<br>Kerala, India<br><b>{{date('M-Y')}}</b></span>
                </td>
                <td></td>
                <td>
                    <span style="font-family: sans-serif;text-align:center;display: block;font-size: 15px;line-height: 20px;">{{date('F d')}}, {{date('Y')}}<br>Calicut</span>
                </td>
                <td></td>

            </tr>
            <tr>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    Employee ID
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    {{$empl->employee_id}}
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    Name
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    {{$empl->name}}
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    Date of Joining
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    {{date('d F, Y', strtotime($empl->joining_date))}}
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    Pay Date
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    25 {{date('F')}}, {{date('Y')}}
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    No.of Working Days
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    30
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    Loss of Pay
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;border-right: 1px solid #000 ;">
                    {{$paid}}
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    Days Worked
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    {{$worked}}
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;">
                    Total Leaves Taken
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;border-right: 1px solid #000 ;">
                    {{$days}}
                </td>
                <td></td>
            </tr>
            <tr style="background: #bdd7ee;border: 1px solid #000;border-right: 1px solid #000 !important;">
                <td colspan="1" style="font-weight: bold;font-family: sans-serif;font-size: 15px;text-align: center;">Earnings</td>
                <td colspan="2" style="font-weight: bold;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-left: 1px solid #000;border-right: 1px solid #000;">Amount</td>
                <td style="font-weight: bold;padding: 15px;font-family: sans-serif;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;">Deduction</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="1" style="font-weight: bold;font-family: sans-serif;font-size: 15px;text-align: center;">Basic Salary</td>
                <td colspan="2" style="padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-left: 1px solid #000;border-right: 1px solid #000;">{{@$empl->basic_salary}}</td>
                <td style="padding: 15px;font-family: sans-serif;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-right: 1px solid #000 ;"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="1" style="font-weight: bold;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;">HRA</td>
                <td colspan="2" style="padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-left: 1px solid #000;border-right: 1px solid #000;">{{@$empl->hra}}</td>
                <td style="padding: 15px;font-family: sans-serif;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-right: 1px solid #000 ;"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="1" style="font-weight: bold;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;">Other Allowences</td>
                <td colspan="2" style="padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-left: 1px solid #000;border-right: 1px solid #000;">{{@$basic}}</td>
                @if($ded>0)
                <td style="padding: 15px;font-family: sans-serif;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-right: 1px solid #000 ;">{{@$ded}}</td>
                @else
                <td style="padding: 15px;font-family: sans-serif;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-right: 1px solid #000 ;"></td>
                @endif
                <td></td>
            </tr>
            <tr>
                <td colspan="1" style="font-weight: bold;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;">Salary Advance</td>
                <td colspan="2" style="padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-left: 1px solid #000;border-right: 1px solid #000;"></td>
                <td colspan="1" style="font-family: sans-serif;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;">{{@$empl->salary_advance}}</td>
                <td></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-weight: bold;font-size: 15px;text-align: center;">
                    Total Earnings
                </td>
                <td colspan="2" style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;">
                    {{$earn}}
                </td>
                <td style="border: 1px solid #000;padding: 15px;font-family: sans-serif;font-size: 15px;text-align: center;border-right: 1px solid #000 !important;">
                    {{@$deduction}}
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="font-family: sans-serif;padding: 15px;font-size: 15px;" colspan="5">*This is a computer generated payslip***No signature required**<br><a style="padding-top: 10px;display: block;" href="https://skiloratech.com/">www.skiloratech.com</a></td>
            </tr>
        </tbody>
    </table>
</body>

</html>