<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <title>{{ $title ?? '' }}</title>
    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="{{ url()->current() }}">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">

    @stack('meta')

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

<x-toast position="toast-top toast-center"/>
</body>

@stack('scripts')
</html>

