<aside id="layout-toggle"
    class="overlay overlay-open:translate-x-0 drawer drawer-start inset-y-0 start-0 hidden h-full [--auto-close:lg] lg:z-50 sm:w-75 lg:block lg:translate-x-0 lg:shadow-none"
    aria-label="Sidebar" tabindex="-1">
    <div class="drawer-body border-base-content/20 h-full border-e p-0">
        <div class="flex h-full max-h-full flex-col">
            <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3 lg:hidden" aria-label="Close"
                data-overlay="#layout-toggle">
                <span class="icon-[tabler--x] size-5"></span>
            </button>
            <div class="text-base-content border-base-content/20 flex flex-col items-center gap-4 border-b px-4 py-6">
                <div class="avatar">
                    <div class="size-17 rounded-full">
                        <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-6.png" alt="avatar" />
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-base-content text-lg font-semibold">
                        {{ Auth::guard('tenant')->user()->name }}
                    </h3>
                    <p class="text-base-content/80">
                        {{ Auth::guard('tenant')->user()->email }}</p>
                </div>

            </div>
            <div class="h-full overflow-y-auto">
                <ul class="menu menu-sm gap-1 px-0">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('tenant.dashboard') }}" class="px-4" wire:navigate
                            wire:current="menu-active">
                            <span class="icon-[tabler--dashboard] size-5"></span>
                            <span class="grow text-[1rem]">Dashboard</span>
                            {{-- <span class="badge badge-sm badge-primary rounded-full">2</span> --}}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('tenant.petugas') }}" wire:navigate class="px-4" wire:current="menu-active">
                            <span class="icon-[tabler--user-check] size-5"></span>
                            <span class="grow text-[1rem]">Petugas</span>
                        </a>
                    </li>

                     <li>
                         <a href="{{ route('tenant.settings') }}" wire:navigate class="px-4"
                             wire:current="menu-active">
                             <span class="icon-[tabler--settings] size-5"></span>
                             <span class="grow text-[1rem]">Pengaturan</span>
                         </a>
                     </li>
                 </ul>
            </div>

        </div>
    </div>
</aside>
<!-- ---------- END MAIN SIDEBAR ---------- -->
