<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        [data-theme="dark"] body {
            background-color: #282a36;
            color: #f8f8f2;
        }

        [data-theme="light"] body {
            background-color: #f1f1f1;
            color: #282a36;
        }

        #sidebar {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-closed {
            width: 0 !important;
            padding: 0 !important;
            border: none !important;
        }

        #overlay {
            transition: background-color 0.3s ease-in-out;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            font-weight: 500;
        }

        [data-theme="dark"] .sidebar-link:hover {
            background-color: #44475a;
        }

        [data-theme="light"] .sidebar-link:hover {
            background-color: #e0e0e0;
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, #696cff, #696cff80);
            color: #fff;
            box-shadow: 0 0 10px #696cff80;
        }

        .sidebar-link span:last-child {
            flex-grow: 1;
        }
    </style>

    <script>
        // Apply theme from local storage before page load
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

    <livewire:styles />
</head>

<body class="min-h-screen flex">
    <aside id="sidebar" class="bg-base-100 w-80 md:w-64 p-4 overflow-hidden shadow">
        <div class="flex items-center gap-4 px-4 mb-6">
            <span class="icon-[tabler--brand-laravel] text-primary text-4xl"></span>
            <h1 class="text-2xl font-bold text-base-content">Materio</h1>
        </div>
        <ul id="sidebar-menu">
            <li><a href="/admin" class="sidebar-link text-base-content"><span
                        class="icon-[tabler--smart-home]"></span><span>Dashboard</span></a></li>
            <li><a href="/admin/users" class="sidebar-link text-base-content"><span
                        class="icon-[tabler--users]"></span><span>Users</span></a></li>
            <li><a href="/admin/settings" class="sidebar-link text-base-content"><span
                        class="icon-[tabler--settings]"></span><span>Settings</span></a></li>
        </ul>
    </aside>
    <div id="overlay" class="fixed inset-0  z-40 hidden"></div>
    <div class="flex-1 flex flex-col">
        <header class="bg-base-100 shadow-md p-4 flex items-center justify-between px-6">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="btn btn-primary btn-circle">
                    <span class="icon-[tabler--menu-2]"></span>
                </button>
                <h2 class="text-2xl font-bold text-base-content">Dashboard</h2>
            </div>
            <div class="flex items-center gap-4">
                <button id="theme-toggle" class="btn btn-primary btn-circle">
                    <span class="icon-[tabler--sun] hidden dark:inline"></span>
                    <span class="icon-[tabler--moon] inline dark:hidden"></span>
                </button>
            </div>
        </header>
        <main class="p-8 flex-1">
            {{ $slot }}
        </main>
    </div>

    <livewire:scripts />

    </body>

</html>
