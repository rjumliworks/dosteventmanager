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
            margin-bottom: 50px; /* Space for the footer */
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
    <div class="footer">
        
        <table style="border-bottom-style: hidden; border-right-style: hidden; border-top-style: hidden; border-left-style: hidden;">
            <tr>
                <td style="width: 100%; text-align: left; font-weight: bold;"><hr/></td>
            </tr>
        </table>
        <table style="margin-top: -5px; border-bottom-style: hidden; border-right-style: hidden; border-top-style: hidden; border-left-style: hidden;">
            <tr>
                <td style="border-right-style: hidden; width: 3%; text-align: right;">-</td>
                <td style="border-right-style: hidden;" style="width: 50%; text-align: left; font-size: 10px;"><br/> <span style="font-weight: bold; color: #072388;">123456789</span></td>
                <td style="border-left-style: hidden; width: 50%; text-align: right; font-size: 10px;">FM-FOS-SET F11 (front page) <br/>Rev 02/07-01-23</td>
                
            </tr>
        </table>
    </div>


    <div class="content">
        <div class="header">
            <div style="font-family:Arial;">
                <img src="{{ public_path('images/logo-sm.png') }}" alt="tag" style="position: absolute; top: -4; left: 60; width: 50px; height: 50px;">
                <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">Republic of the Philippines</center>
                <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
                <center style="font-size: 11px;">Pettit Baracks, Zamboanga City | (062) 991-1024 | dost9info@gmail.com</center>
                <br/>
                <center style="margin-top: 8px; font-size: 11px;  color:#000; font-weight: bold; padding: 2px;">DOST Region Office No. IX</center>
                <center style="font-size: 11px; background-color: #097eeb; color:#fff; font-weight: bold; padding: 2px; text-transform: uppercase; ">LIST OF PARTICIPANTS</center>
            </div> 
        </div>
        <table style="border: 1px solid black; margin-top: 15px;">
            <thead style="background-color:#c8c8c8; padding: 5px; font-size: 10px;">
                <tr>
                    <th style="vertical-align: middle;" rowspan="2" width="3%">#</th>
                    <th style="vertical-align: middle;" rowspan="2" width="16%">NAME</th>
                    <th style="vertical-align: middle;" rowspan="2" width="19%">AGENCY/FIRM</th>
                    <th style="vertical-align: middle;" rowspan="2" width="15%">DESIGNATION</th>
                    <th style="vertical-align: middle;" rowspan="2" width="8.5%">CONTACT NO.</th>
                    <th style="vertical-align: middle;" rowspan="2" width="17%">EMAIL</th>
                    <th style="vertical-align: middle;" rowspan="2" width="3%">SEX</th>
                    <th style="vertical-align: middle;" rowspan="2" width="3%">AGE</th>
                    <th style="vertical-align: middle; font-size: 9px;" colspan="3" width="9%">Please check if applicable</th>
                    <th style="vertical-align: middle;" rowspan="2" width="8.4%">SIGNATURE</th>
                </tr>
                <tr>
                    <th width="3%">4Ps</th>
                    <th width="3%">PWD</th>
                    <th width="3%">IP</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i <= count($data); $i++)
                    <tr style="text-align: center;">
                        <td style="text-align: center;">{{ $i+1 }}</td>
                        @if(isset($data[$i]))
                            @php $attendee = $data[$i]; @endphp
                            <td>{{ $attendee->firstname ?? '' }} {{ $attendee->lastname ?? '' }}</td>
                            <td>{{ $attendee->detail->affiliation ?? '' }}</td>
                            <td>{{ $attendee->detail->designation ?? '' }}</td>
                            <td>{{ $attendee->contact_no ?? '' }}</td>
                            <td>{{ $attendee->email ?? '' }}</td>
                            <td>{{ $attendee->detail->sex->name[0] ?? '' }}</td>
                            <td>{{ $attendee->detail->age ?? '-' }}</td>
                            <td>{{ $attendee->is_4ps ? '✔' : '' }}</td>
                            <td>{{ $attendee->is_pwd ? '✔' : '' }}</td>
                            <td>{{ $attendee->is_ip ? '✔' : '' }}</td>
                            <td>
                                @if(!empty($attendee->participant->detail->signature_base64))
                                    <img src="{{ $attendee->participant->detail->signature_base64 }}" 
                                        style="width:70px; height:auto;" alt="Signature">
                                @else
                                    <span>No signature</span>
                                @endif
                            </td> 
                        @else
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
                        @endif
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    
</body>
</html>