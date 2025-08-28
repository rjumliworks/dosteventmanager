<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0; /* Remove page margins for full bg */
        }
        @font-face {
            font-family: 'Great Vibes';
            src: url({{ public_path('fonts/LeckerliOne-Regular.ttf') }}) format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* Full background */
        .certificate-bg {
            position: fixed; /* Always behind */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Content with margins */
        .content {
            margin: 40px 60px; /* Your custom safe margins */
            position: relative;
            z-index: 1;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Background -->
    <img src="{{ public_path('images/bg-cert1.jpg') }}" class="certificate-bg">

    <!-- Foreground Content -->
    <div class="content">
        <div style="text-align: center; margin-top: 125px; margin-bottom: 20px;">
            <img src="{{ public_path('images/dost.png') }}" alt="tag" style="width: 80px; height: 80px; margin-right: 20px;">
            <img src="{{ public_path('images/bagongpilipinas.png') }}" alt="tag" style="width: 80px; height: 80px;">
        </div>

        <h1 style="text-align: center; font-size: 36px; margin-top: 20px;">CERTIFICATE OF PARTICIPATION</h1>
        <p style="text-align: center; font-size: 20px; margin-top: -10px;">This certificate is proudly presented to</p>

        <h1 style="text-align: center; font-size: 36px; margin-top: 20px; margin-bottom: -30px; font-family: 'Great Vibes', cursive;">
            <ins>{{$data['participant']['firstname'].' '.$data['participant']['middlename'][0].'. '.$data['participant']['lastname']}}</ins>
        </h1>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <p style="text-align: justify; font-size: 15px; line-height: 1.4; margin-top: 60px;">
                In grateful recognition for his active participation during the
                <b><ins>"{{$data['session']['title']}}"</ins></b> of the
                <b><ins>{{$data['session']['event']['name']}}</b></ins> held at 
                {{ $data['session']['venue']['name']}}, {{ $data['session']['event']['detail']['venue']}}.
            </p> 

        
            <p style="text-align: center; margin-top: 20px; font-size: 15px;">
                Given this {{ \Carbon\Carbon::now()->format('jS \\d\\a\\y \\o\\f F Y') }} in Zamboanga City, Philippines.
            </p>
        </div>

        <div style="text-align: center; position: absolute; bottom: 60; left: 50%; transform: translateX(-50%);">
            <h1 style="font-size: 17px; margin: 0;">JENNIFER A. PIDOR</h1>
            <p style="font-size: 13px; margin: 0;">OIC - Regional Director</p>
        </div>
    </div>
</body>
</html>
