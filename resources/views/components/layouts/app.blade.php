<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>

    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Onton Radar</title>


    <!-- Basic Meta Tags -->
    <meta name="robots" content="index, follow"/>
    <!--[if BLOCK]><![endif]-->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="data4796"/>
    <meta name="keywords" content="data4796"/>
    <meta name="author" content="ONTON Radar"/>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">

    <x-ui.home.navbar/>

<x-main with-nav>


    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-main>

    <x-ui.home.footer/>

<x-toast/>
</body>

@stack('scripts')
</html>

