<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>

    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{ config('app.name') . ' ' . $title ?? '' }}</title>


    <meta name="robots" content="index, follow"/>
    <meta name="description"
          content="{{ config('app.name') }} Dashboard"/>
    <meta name="keywords" content="{{ config('app.name') }}"/>
    <meta name="author" content="{{ config('app.name') }}"/>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans bg-base-200">


@include('components.layouts.navbar.user-navbar')



<x-main with-nav collapsible>

    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-200">

        @if(auth()->user())
            <x-list-item :item="auth()->user()" value="name" sub-value="email" no-separator no-hover class="pt-2">
                <x-slot:actions>
                    <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
                              link="/logout"/>
                </x-slot:actions>
            </x-list-item>

            <x-menu-separator/>
        @endif

        @include('components.layouts.sidebar.user-sidebar')

    </x-slot:sidebar>


    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-main>


<x-toast position="toast-top toast-center"/>
</body>

@stack('scripts')
</html>

