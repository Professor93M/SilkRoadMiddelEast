<!DOCTYPE html>
<html class="h-full bg-gray-700" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="apple-mobile-web-app-title" content="Silk Road MiddleEast">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&family=Saira+Condensed:wght@500&display=swap" rel="stylesheet"> 
        <!-- Styles -->
        <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
        <link rel="stylesheet" href={{ asset('css/hover-min.css') }}>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <style>
            body {
                font-family: 'Roboto', sans-serif;
            }
            body::-webkit-scrollbar {
                width: 0.8em;
                height: 0.2em;
            }

            body::-webkit-scrollbar-track {
                box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            }

            body::-webkit-scrollbar-thumb {
                background-color: darkgrey;
                outline: 1px solid slategrey;
            }
        </style>
        <!-- Scripts -->
        @routes
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/vue-number-input.min.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="antialiased">
        @inertia
    </body>
</html>
