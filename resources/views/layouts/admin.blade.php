<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">

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
            background-color: #1a202c;
            color: #a0aec0;
        }

        .sidebar-closed {
            width: 0 !important;
            padding: 0 !important;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease-in-out;
        }

        [data-theme="dark"] .sidebar-link:hover {
            background-color: #2d3748;
        }

        [data-theme="light"] .sidebar-link:hover {
            background-color: #edf2f7;
        }

        .sidebar-link.active {
            background-color: #2d3748;
            color: #fff;
        }

        [data-theme="light"] .sidebar-link.active {
            background-color: #4299e1;
            color: #fff;
        }

        .sidebar-link span:last-child {
            flex-grow: 1;
        }
    </style>

    <script>
        // Apply theme from local storage before page load
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

    <livewire:styles />
</head>

<body class="min-h-screen flex">
    <aside id="sidebar"
        class="bg-base-100 w-72 p-4 transition-all duration-300 ease-in-out overflow-hidden whitespace-nowrap shadow-lg">
        <h1 class="text-2xl font-bold mb-3 text-base-content">Admin</h1>
        <ul id="sidebar-menu">
            <li><a href="/admin" class="sidebar-link text-base-content"><span
                        class="icon-[tabler--dashboard]"></span><span>Dashboard</span></a></li>
            <li><a href="/admin/users" class="sidebar-link text-base-content"><span
                        class="icon-[tabler--users]"></span><span>Users</span></a></li>
            <li><a href="/admin/settings" class="sidebar-link text-base-content"><span
                        class="icon-[tabler--settings]"></span><span>Settings</span></a></li>
        </ul>
    </aside>
    <div class="flex-1 flex flex-col">
        <header class="bg-base-100 shadow-lg p-[8px] flex items-center px-6">
            <button id="sidebar-toggle" class="btn btn-success dark:btn-primary btn-circle">
                <span class="icon-[tabler--menu-2]"></span>
            </button>
            <h2 class="text-2xl font-bold ml-6 text-base-content">Dashboard</h2>
            <div class="ml-auto">
                <button id="theme-toggle" class="btn btn-circle">
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

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        const sidebarMenu = document.getElementById('sidebar-menu');

        // Initially hide sidebar on mobile
        if (window.innerWidth < 768) {
            setTimeout(() => {
                sidebar.classList.add('sidebar-closed');
            }, 100);
        }

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-closed');
        });

        // Theme toggle
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });

        // Active menu item
        const currentUrl = window.location.pathname;
        const menuLinks = sidebarMenu.querySelectorAll('a');

        menuLinks.forEach(link => {
            if (link.getAttribute('href') === currentUrl) {
                link.classList.add('active');
            }
        });
    </script>
</body>

</html>
