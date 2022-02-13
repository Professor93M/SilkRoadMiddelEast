<!DOCTYPE html>
<html class="h-full bg-gray-700" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Facebook Meta Tags -->
        <meta property="og:site_name" content="مايكرو للتقسيط"/>
        <meta property="og:title" content="{{ isset($title) ? $title . ' - مايكرو للتقسيط' : 'مايكرو للتقسيط' }}">
        <meta property="og:description" content="{{ isset($description) ? $description : 'شركة مايكرو للتقسيط للبيع المباشر وبالتقسيط المريح حيث كل ماهو جديد ومميز' }}">
        <meta property="og:image" content="{{ isset($cover) ? 'https://microstoreiq.com/images/'.$cover : 'https://microstoreiq.com/images/logo.png?2126feb6de933f39282cd3c6812d8921' }}">
        <meta property="og:image:width" content="1200"/>
        <meta property="og:image:height" content="630"/>

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="microstoreiq.com">
        <meta property="twitter:creator" content="@IProfessor_Man">
        <meta property="twitter:url" content="https://www.microstoreiq.com/">
        <meta name="twitter:title" content="{{ isset($title) ? $title . ' - مايكرو للتقسيط' : 'مايكرو للتقسيط' }}">
        <meta name="twitter:description" content="{{ isset($description) ? $description : 'شركة مايكرو للتقسيط للبيع المباشر وبالتقسيط المريح حيث كل ماهو جديد ومميز' }}">
        <meta name="twitter:image" content="{{ isset($cover) ? 'https://microstoreiq.com/images/'.$cover : 'https://microstoreiq.com/images/logo.png?2126feb6de933f39282cd3c6812d8921' }}">

        {{-- <link rel="canonical" href="https://microstoreiq.com" /> --}}
        <link rel="apple-touch-icon" href="https://microstoreiq.com/images/logo.png?2126feb6de933f39282cd3c6812d8921">
        <link rel="shortcut icon" href="https://microstoreiq.com/images/logo.png?2126feb6de933f39282cd3c6812d8921">
        <meta name="apple-mobile-web-app-title" content="مايكرو للتقسيط">
        <meta name="google-site-verification" content="7LYppMP4_uKGRVkwhTqXeDecdGFoZUtkZRwSWO9z7sA" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
        <link rel="stylesheet" href={{ asset('css/hover-min.css') }}>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <style>
            body {
                font-family: 'Almarai', sans-serif;
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
    <body Dir="rtl" class="antialiased">
        @inertia
    </body>
</html>
