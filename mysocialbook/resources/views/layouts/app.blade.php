<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Radio+Canada:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    @stack('styles')
    @stack('scripts')

    <title>@yield('title') - MySocialBook</title>
</head>
<body class="radio-canada-normal">

    @yield('content')

</body>
</html>