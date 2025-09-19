<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            html * {
                font-family:Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 0;
            }
            .image {
                width: 100%;
                height: auto;
            }
        </style>
    </head>

    <body>
        @foreach($lists as $list)
        <img class="image" src="<?php echo $list['qrCodeImage']; ?>" alt="QR Code"/>
        <p style="font-size: 9px;">{{ $list['name']}}</p>
        @endforeach
    </body>
</html>

