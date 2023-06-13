<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Tokopedia</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="w-full min-h-screen flex sm:justify-between items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-6/12 h-screen grid place-items-center">
                <div class="bg-white w-7/12 shadow-md overflow-hidden sm:rounded-lg px-6 py-4">
                    {{ $slot }}
                </div>
            </div>
            <div class="w-6/12 h-screen" style="background-image: url('/assets/guest.png'); background-size: cover; background-repeat: no-repeat; background-position: left;">
            
            </div>

        </div>
    </body>
</html>
