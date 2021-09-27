<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/favicon.ico') }}">
        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
        />
        <link rel="stylesheet" href="{{ mix('css/styles.css') }}">
        <meta name="robots" content="noindex, nofollow" />

        @if(count($allSeoData))
            <title>{{ $allSeoData['title'] }}</title>
            <meta name="description" content="{{ $allSeoData['description'] }}"/>
            <meta name="keywords" content="{{ $allSeoData['keywords'] }}">

            <meta property="og:title" content="{{ $allSeoData['og_title'] }}">
            <meta property="og:description" content="{{ $allSeoData['og_description'] }}">
            <meta property="og:image" content="{{ $allSeoData['image'] }}">
            <meta property="og:url" content="{{ request()->fullUrl() }}">
            <meta property="og:type" content="page">
            {!! $allSeoData['scripts'] !!}
        @endif
        <!-- Scripts -->
        @routes
        <script src="{{asset('../landing_resources/js/jquery-1.11.0.min.js')}}"></script>
        <script src="{{asset('../landing_resources/js/jquery-migrate-1.2.1.min.js')}}"></script>
        <script src="{{asset('../landing_resources/js/slick.min.js')}}"></script>

        <script src="{{asset('../landing_resources/js/general.js')}}"></script>
        <script src="{{asset('../landing_resources/js/slide.js')}}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>

    </head>
    <body class="font-sans antialiased">
    {!! $allSeoData['no_scripts'] !!}
    @inertia
    </body>
</html>
