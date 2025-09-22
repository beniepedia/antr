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
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <livewire:styles />
</head>

<body class="min-h-screen">
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 z-50 overflow-y-auto hidden md:block">
        @yield('navbar')
    </aside>

    <header class="fixed top-0 left-0 right-0 z-40 md:ml-64">
        @yield('topbar')
    </header>

    <div class="md:ml-64 flex flex-col min-h-screen">
        <main class="p-8 flex-1 mt-16">
            @yield('content')
        </main>
    </div>

    <livewire:scripts />

</body>

</html>
