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
    <livewire:styles />
</head>

<body class="font-sans antialiased">

    @yield('content')

    <livewire:scripts />

    @stack('scripts')

    <script>
        @if (session('success'))
            window.notyf.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            window.notyf.error("{{ session('error') }}");
        @endif

        window.addEventListener('notify', event => {
            const type = event.detail.type || 'success';
            const message = event.detail.message || '';

            if (type === 'success') {
                window.notyf.success(message);
            } else if (type === 'error') {
                window.notyf.error(message);
            } else {
                window.notyf.open({
                    type,
                    message
                });
            }
        });
    </script>
</body>

</html>
