<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @inertiaHead

    <meta name="description" content="线上影音点播">
    <meta property="og:title" content="Online Player">
    <meta property="og:description" content="线上影音点播">
    <meta name="twitter:card" content="summary_large_image">

    @vite('resources/js/app.ts','static')
</head>

<body class="font-sans antialiased">
    @inertia
</body>
</html>
