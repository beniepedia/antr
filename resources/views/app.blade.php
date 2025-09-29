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

    <script>
        @if (session('success'))
            window.notyf.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            window.notyf.error("{{ session('error') }}");
        @endif


        document.addEventListener('livewire:init', () => {
            Livewire.on('notify', ({
                type,
                message
            }) => {
                console.log(notyf);
                notyf.success("asdasdad")
                // kalau type gak valid, fallback ke error
                if (typeof window.notyf[type] === "function") {
                    window.notyf[type](message);
                } else {
                    window.notyf.error(message);
                }
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            if (window.Livewire && window.Livewire.hotReload) {
                console.log("%c✅ Livewire Hot Reload aktif!", "color: green; font-weight: bold;");
            } else {
                console.warn("⚠️ Livewire Hot Reload TIDAK aktif. Fallback reload halaman.");
            }

            // Optional: pantau koneksi websocket
            const wsCheck = setInterval(() => {
                const ws = window.Livewire?.hotReload?.connection;
                if (ws) {
                    console.log("🔌 Hot Reload WebSocket status:", ws.readyState === 1 ? "Connected" :
                        "Disconnected");
                    clearInterval(wsCheck);
                }
            }, 1000);
        });
    </script>
</body>

</html>
