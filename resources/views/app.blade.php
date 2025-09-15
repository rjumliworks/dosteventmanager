<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=375, initial-scale=1.0">
        <title inertia>DOST-IX</title>
        <meta name="description" content="DOST IX">
        <meta name="keywords" content="DOST, RSTW, HANDA PILIPINAS">
        <meta name="author" content="Krad">
        <meta property="og:title" content="DOSTIX RSTW & HANDA - Department of Science and Technology ">
        <meta property="og:description" content="Information Management System">
        <meta property="og:image" content="{{ asset('images/dost.png') }}">
        <meta property="og:url" content="rstwhanda.dost9.ph">
        <meta name="twitter:card" content="summary_large_image">
        <link rel="shortcut icon" href="{{ URL::asset('images/favicon.ico') }}">
        @vite(['resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>