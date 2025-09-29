<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'App')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        
    @endif --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles


</head>

<body class="font-sans antialiased">

    @yield('content')

    @livewireScripts

    @stack('scripts')
    {{-- 
    <script type="text/javascript">
       
    </script> --}}
</body>

</html>
