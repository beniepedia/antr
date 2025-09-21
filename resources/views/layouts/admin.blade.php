<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin Dashboard</title>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            .sidebar-closed {
                width: 0 !important;
                padding: 0 !important;
            }
        </style>

        <livewire:styles />
    </head>
    <body class="bg-base-200 min-h-screen flex">
        <aside id="sidebar" class="bg-base-100 w-64 p-4 md:w-64 md:p-4 transition-all duration-300 ease-in-out overflow-hidden whitespace-nowrap">
            <h1 class="text-xl font-bold mb-4">Admin Menu</h1>
            <ul>
                <li><a href="#" class="block py-2 px-4 hover:bg-base-300 rounded">Dashboard</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-base-300 rounded">Users</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-base-300 rounded">Settings</a></li>
            </ul>
        </aside>
        <div class="flex-1 flex flex-col">
            <header class="bg-base-100 shadow-md p-4 flex items-center">
                <button id="sidebar-toggle" class="btn btn-primary">
                    <span class="icon-[tabler--menu-2]"></span>
                </button>
                <h2 class="text-xl font-bold ml-4">Dashboard</h2>
            </header>
            <main class="p-8 flex-1">
                {{ $slot }}
            </main>
        </div>

        <livewire:scripts />

        <script>
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');

            // Initially hide sidebar on mobile
            if (window.innerWidth < 768) {
                setTimeout(() => {
                    sidebar.classList.add('sidebar-closed');
                }, 100);
            }

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('sidebar-closed');
            });
        </script>
    </body>
</html>
