<aside id="sidebar"
    class="h-full w-64 md:w-64 p-4 overflow-y-auto shadow-xl border-r border-base-300 bg-base-100">
    <div class="flex items-center gap-4 px-4 mb-6">
        <span class="icon-[tabler--brand-laravel] text-primary text-4xl"></span>
        <h1 class="text-2xl font-bold text-base-content">Antrianku</h1>
    </div>
    <ul id="sidebar-menu">
        <li><a href="{{ route('tenant.dashboard') }}" class="sidebar-link text-base-content"><span
                    class="icon-[tabler--smart-home]"></span><span>Dashboard</span></a></li>
        <li><a href="#" class="sidebar-link text-base-content"><span
                    class="icon-[tabler--users]"></span><span>Pelanggan</span></a></li>
        <li><a href="#" class="sidebar-link text-base-content"><span
                    class="icon-[tabler--settings]"></span><span>Pengaturan</span></a></li>
    </ul>
</aside>