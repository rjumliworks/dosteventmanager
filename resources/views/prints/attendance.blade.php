<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        /* Styles for the footer */
        @page {
           
        }

        html * {
            font-family:Arial, Helvetica, sans-serif;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }

        .content {
            margin-bottom:55px; /* Space for the footer */
        }

        table,
        td,
        th {
            border: .5px solid black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            padding: 3px;
            vertical-align: top;
        }
        td {
            padding: 3px;
            /* vertical-align: top; */
            /* text-align: center; */
        }
        input[type=checkbox] {
            transform: scale(.7);
        }
        .a {
            width: 55px; 
            height: 55px;
        }
        label {
            display: block;
            padding-left: 15px;
            text-indent: -15px;
        }
        input {
            width: 13px;
            height: 13px;
            padding: 0;
            margin:0;
            vertical-align: bottom;
            position: relative;
            top: -5px;
            left: 7px;
            *overflow: hidden;
        }
        input[type=checkbox] { display: inline; }
        input[type=checkbox]:before { font-family: DejaVu Sans; }
        label {
            display: inline-block;
        }
        .footer {
            position: fixed;
            bottom: -10;
            width: 100%;
            left: 0;
            margin-left: auto;
            margin-right: auto;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="font-family:Arial;">
            <img src="{{ public_path('images/logo-sm.png') }}" alt="tag" style="position: absolute; top: -4; left: 60; width: 50px; height: 50px;">
            <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">Republic of the Philippines</center>
            <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
            <center style="font-size: 11px;">Pettit Baracks, Zamboanga City | (062) 991-1024 | dost9info@gmail.com</center>
            <br/>
            <center style="margin-top: 8px; font-size: 11px;  color:#000; font-weight: bold; padding: 2px;">DOST Region Office No. IX</center>
            <center style="font-size: 11px; background-color: #097eeb; color:#fff; font-weight: bold; padding: 2px; text-transform: uppercase; ">ATTENDANCE SHEET</center>
        </div>
    </div>
    <div>
        <table style="border: 1px solid black; margin-top: 10px;">
            <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
                <tr>    
                    <th style="vertical-align: middle;" width="33.3%">EVENT</th>
                    <th style="vertical-align: middle;" width="33.3%">VENUE</th>
                    <th style="vertical-align: middle;" width="33.3%">INCLUSIVE DATE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">{{$data['title']}}</td>
                    <td style="text-align: center;">{{$data['venue']['name']}}, {{$data['venue']['establishment']}}</td>
                    <td style="text-align: center;">{{$date}}</td>
                </tr>
            </tbody>
        </table>
        <table style="border: 1px solid black; margin-top: 10px;">
            <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
                <tr s>
                    <th style="vertical-align: middle;" rowspan="2" width="3%">#</th>
                    <th style="vertical-align: middle;" rowspan="2" width="15%">NAME</th>
                    <th style="vertical-align: middle;" rowspan="2" width="15%">AGENCY/FIRM</th>
                    <th style="vertical-align: middle;" rowspan="2" width="15%">DESIGNATION</th>
                    <th style="vertical-align: middle;" rowspan="2" width="10%">CONTACT NO.</th>
                    <th style="vertical-align: middle;" rowspan="2" width="10%">EMAIL</th>
                    <th style="vertical-align: middle;" rowspan="2" width="5%">SEX</th>
                    <th style="vertical-align: middle;" rowspan="2" width="5%">AGE</th>
                    <th style="vertical-align: middle;" colspan="3" width="15%">Please check</th>
                    <th style="vertical-align: middle;" rowspan="2" width="10%">SIGNATURE</th>
                </tr>
                <tr>
                    <th width="5%">4Ps</th>
                    <th width="5%">PWD</th>
                    <th width="5%">IP</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 20; $i++)
                    <tr>
                        <td style="text-align: center;">{{ $i }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <table style="border: 1px solid black; font-size: 10px; margin-top: 10px; page-break-inside: avoid;">
            <tbody>
                <tr>
                    <td style="min-height: 50px; border-bottom-style: hidden;"><span style="font-size:9px; color: #606060;">Facilitated by:</span></td>
                    <td style="min-height: 50px; border-bottom-style: hidden;"><span style="font-size:9px; color: #606060;">Noted by:</span></td>

                </tr>
                <tr>
                    <td style="min-height: 50px; padding: 15px; border-bottom-style: hidden;"></td>
                    <td style="min-height: 50px; padding: 15px; border-bottom-style: hidden;"></td>
                </tr>
                <tr style="text-align: center;">
                    <td width="50%"><span style="font-weight: bold; font-size: 11px; color: #072388; text-transform: uppercase;">{{$head['user']['profile']['firstname']}} {{$head['user']['profile']['middlename'][0]}}. {{$head['user']['profile']['lastname']}}</span><hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 50%;">Name and Signature</td>
                    <td width="50%"><span style="font-weight: bold; font-size: 11px; color: #072388; text-transform: uppercase;">AW</span><hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 50%;">Unit Head </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="footer">
        <table style="border-bottom-style: hidden; border-right-style: hidden; border-top-style: hidden; border-left-style: hidden;">
            <tr>
                <td style="width: 40%; text-align: left; font-weight: bold;"><hr/></td>
            </tr>
        </table>
        <table style="margin-top: -5px; border-bottom-style: hidden; border-right-style: hidden; border-top-style: hidden; border-left-style: hidden;">
            <tr>
                <td style="border-right-style: hidden; width: 3%; text-align: right;"> <img src="<?php echo $qrCodeImage; ?>"  width="30" height="30" alt="QR Code"></td>
                <td style="border-right-style: hidden;" style="width: 50%; text-align: left; font-size: 10px;"><br/> <span style="font-weight: bold; color: #072388;">{{$data['code']}}</span></td>
                <td style="border-left-style: hidden; width: 50%; text-align: right; font-size: 10px;">FM-FOS-SET F11 (front page) <br/>Rev 02/07-01-23</td>
                
            </tr>
        </table>
    </div>




    
</body>
</html>