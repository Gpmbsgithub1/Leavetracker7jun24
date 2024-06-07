<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <meta name="format-detection" content="telephone=no">



    <style>
        body {
            margin: 0;
            padding: 0;
            min-width: 100%;
            width: 100% !important;
            height: 100% !important;
        }
        
        body,
        table,
        td,
        div,
        p,
        a {
            -webkit-font-smoothing: antialiased;
            text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            line-height: 100%;
        }
        
        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            border-collapse: collapse !important;
            border-spacing: 0;
        }
        
        img {
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        
        #outlook a {
            padding: 0;
        }
        
        .ReadMsgBody {
            width: 100%;
        }
        
        .ExternalClass {
            width: 100%;
        }
        
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }
        
        @media all and (max-width: 600px) {
            .floater {
                width: 320px;
            }
        }
        
        a,
        a:hover {
            color: #127DB3;
        }
        
        .footer a,
        .footer a:hover {
            color: #999999;
        }
    </style>
    <title>Document Uploaded</title>

</head>


<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
    background-color: rgb(241 73 101);
    color: #000000;" bgcolor="#FFFFFF" text="#000000">
    <table width="530" border="0" cellpadding="0" cellspacing="0" style="margin: auto;">
        <tbody>
            <tr>
                <td align="center" valign="top" style="
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            padding: 0;
            padding-left: 0;
            padding-right: 0;
            width: 87.5%;
            padding-top: 60px;
            padding-bottom: 30px;
            background: rgb(241 73 101);
            ">
                    <a target="_blank" style="text-decoration: none;font-family: sans-serif;line-height: 20px;font-size: 25px;color: rgb(255 255 255);text-align: left;padding: 0px 10px;font-weight: bold;" "="  href="https://leavetrack.skiloratech.com/">Leave Tracker</a>
            </td>
        </tr>
    </tbody></table>
    <table width="530 " align="center " border="0 " cellpadding="0 " cellspacing="0 " style=" border-collapse: collapse; border-spacing: 0; margin: auto; padding: 0; border: 2px solid rgb(241 73 101); margin-top: 0px; width: 530px; overflow: hidden;
                        border-radius: 0; margin-bottom: 20px; " class="background ">

        <tbody><tr>
            <td align="center " valign="top " style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-top: 5px; " bgcolor="#FFFFFF ">

                <table border="0 " cellpadding="0 " cellspacing="0 " align="center " width="600 " style="border-collapse: collapse; border-spacing: 0; padding: 0; width: 100%; max-width: 600px; ">

                    <tbody>
                        <tr>
                            <td>
                                <img src="{{asset('content/img/doc.png')}}" style="
    width: 70px;
    padding: 25px 25px 0px;
    margin: auto;
">
                            </td>
                        </tr>
                        <tr>
                        <td align="center " valign="top " style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; padding-top: 10px;padding-bottom: 25px; ">
                            <h1 style="font-family: sans-serif;font-size: 20px;color: #3d3d3d;margin-bottom: 5px;text-align: left;font-weight: 300;margin-top: 20px;padding: 0px ;font-weight: bold; ">{{$doc->document_name}} Uploaded</h1>
                            <h6 style="font-family: sans-serif;font-size: 18px;color: #3d3d3d;margin-bottom: 5px;text-align: left;font-weight: 300;margin-top: 30px;padding: 0px ; ">Dear {{$employee->name}},</h6>
                            <p style="font-family: sans-serif;font-size: 16px;color: #3d3d3d;margin-bottom: 5px;text-align: left;font-weight: 300;margin-top: 20px;padding: 0px ; ">{{$doc->document_name}} is uploaded to your folder.</p>
                        </td>
                    </tr>
                 
                        <tr>
                            <td><p style="font-family: sans-serif;line-height: 17px;font-size: 18px;color: #3d3d3d;margin-bottom: 0px;text-align: left;font-weight: 500;padding: 0px 32px; ">Human Resource,</p> <br><p style="font-family: sans-serif;line-height:
                        20px;font-size: 15px;color: #3d3d3d;margin-bottom: 30px;text-align: left;padding: 0px 32px;margin-top: 0; ">Skilora</p></td>
                        </tr>

                        <tr>
                        <td align="left " style="padding-bottom: 50px;padding-top: 45px;padding-left: 30px; ">
                            @if($employee->hr==1)
                            <a target="blank " href="{{route('hr.my_docs')}}" style=" margin-right: 15px; cursor:pointer; background: #ffffff; width: 70px; color: #3d3d3d; font-family: sans-serif; font-size: 14px; padding: 10px 15px; border-radius: 25px; font-weight: 600;
                        text-decoration: none; margin-bottom: 35px; border: 2px solid #4caf50; text-align: center; ">View</a>
                        @elseif($employee->hr==0)
                        <a target="blank " href="{{route('employee.documents')}}" style=" margin-right: 15px; cursor:pointer; background: #ffffff; width: 70px; color: #3d3d3d; font-family: sans-serif; font-size: 14px; padding: 10px 15px; border-radius: 25px; font-weight: 600;
                        text-decoration: none; margin-bottom: 35px; border: 2px solid #4caf50; text-align: center; ">View</a>
                        @endif
                        </td>
                     
                    </tr>
                 
                </tbody></table>
            </td>
        </tr>
        <tr>
            <td>
                <a href="# " style=" font-family: sans-serif; font-size: 15px; color: #ffffff; font-weight: 300; padding: 28px 10px; margin: auto; display: block; text-align: center; ">leavetrack.skiloratech.com</a>
            </td>
        </tr>
    </tbody></table>
    
    

    



</body></html>