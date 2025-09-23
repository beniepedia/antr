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

<body class="font-sans antialiased">
    <div class="bg-base-200 flex min-h-screen flex-col">

        <x-header></x-header>

        @include('layouts.partials.tenant-sidebar')

        <div class="flex grow flex-col lg:ps-75">
            <!-- ---------- MAIN CONTENT ---------- -->
            <main class="mx-auto w-full max-w-7xl flex-1 p-6">
                <div class="grid grid-cols-1 gap-6">

                    @yield('content')
                </div>
            </main>
            <!-- ---------- END MAIN CONTENT ---------- -->

            <!-- ---------- FOOTER CONTENT ---------- -->
            <footer class="bg-base-100">
                <div class="mx-auto h-14 w-full max-w-7xl px-6"></div>
            </footer>
            <!-- ---------- END FOOTER CONTENT ---------- -->
        </div>
    </div>

    <livewire:scripts />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('message'))
                window.notyf.success("{{ session('message') }}");
            @endif

            @if (session('error'))
                window.notyf.error("{{ session('error') }}");
            @endif
        });
    </script>
</body>

</html>
