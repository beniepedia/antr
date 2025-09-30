<div class="pt-19">
    <!-- Header -->
    <x-mobile-header title="Profil Saya" />

    <div class="max-w-2xl mx-auto px-4">
        <!-- Profile Hero Section -->
        <div class="relative bg-base-100 rounded-lg  p-6 mb-6 shadow-md overflow-hidden">
            <div class="relative z-10 flex flex-col items-center gap-4">
                <div class="flex flex-col items-center gap-4">
                    <div class="avatar">
                        <div class="w-24 h-24 rounded-full bg-slate-300 border-4 border-slate-400 relative shadow-md">
                            <span
                                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-slate-700 text-3xl font-bold">
                                {{ strtoupper(substr(auth('customer')->user()->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="text-slate-800 text-center">
                        <h1 class="text-2xl font-bold mb-1">{{ auth('customer')->user()->name }}</h1>
                        <p class="text-slate-600 flex items-center justify-center gap-2">
                            <span class="icon-[tabler--brand-whatsapp] size-4 text-green-500"></span>
                            {{ auth('customer')->user()->whatsapp }}
                        </p>
                        @if (auth('customer')->user()->verified_at)
                            <div class="badge badge-success badge-sm mt-2">Terverifikasi</div>
                        @endif
                    </div>
                </div>
                <button wire:click="toggleEdit" class="btn btn-text btn-circle text-slate-700 hover:bg-slate-300">
                    <span class="icon-[tabler--edit] size-6"></span>
                </button>
            </div>
        </div>

        @if ($editing)
            <h3 class="card-title text-lg flex items-center gap-2 mb-2">
                <span class="icon-[tabler--edit] size-5 text-primary"></span>
                Edit Profil
            </h3>
            <!-- Profile Form Card -->
            <div class="card bg-white shadow-lg ">
                <div class="card-body rounded-lg">
                    <!-- Form -->
                    <form wire:submit="save" class="space-y-5">
                        <!-- Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Nama Lengkap</span>
                            </label>
                            <label
                                class="input input-bordered flex items-center gap-3 bg-gray-50 focus-within:bg-white transition-colors">
                                <span class="icon-[tabler--user] size-5 text-gray-500"></span>
                                <input wire:model="name" type="text" class="grow bg-transparent"
                                    placeholder="Masukkan nama lengkap" />
                            </label>
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- WhatsApp -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Nomor WhatsApp</span>
                            </label>
                            <label
                                class="input input-bordered flex items-center gap-3 bg-gray-50 focus-within:bg-white transition-colors">
                                <span class="icon-[tabler--brand-whatsapp] size-5 text-green-500"></span>
                                <input wire:model="whatsapp" type="text" class="grow bg-transparent"
                                    placeholder="6281234567890" />
                            </label>
                            @error('whatsapp')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="form-control pt-2 flex gap-3">
                            <button type="submit"
                                class="btn btn-primary flex-1 btn-lg shadow-md hover:shadow-lg transition-shadow">
                                <span wire:loading class="loading loading-spinner"></span>
                                <span wire:loading.remove class="flex items-center gap-2">
                                    <span class="icon-[tabler--device-floppy] size-5"></span>
                                    Simpan
                                </span>
                            </button>
                            <button type="button" wire:click="toggleEdit" class="btn btn-ghost flex-1 btn-lg">
                                <span class="icon-[tabler--x] size-5"></span>
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <h3 class="card-title text-lg flex items-center gap-2 mb-2">
                <span class="icon-[tabler--info-circle] size-5 text-primary"></span>
                Informasi Akun
            </h3>
            <!-- Additional Info -->
            <div
                class="bg-base-100 border-base-content/25 divide-base-content/25 flex flex-col divide-y rounded-md border shadow-md *:p-3 *:first:rounded-t-md *:last:rounded-b-md">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="icon-[tabler--user] me-3 size-5 text-gray-600"></span>
                        <span class="text-gray-600">Nama</span>
                    </div>
                    <span class="font-medium capitalize">{{ auth('customer')->user()->name }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="icon-[tabler--brand-whatsapp] me-3 size-5 text-gray-600"></span>
                        <span class="text-gray-600">Nomor WhatsApp</span>
                    </div>
                    <span class="font-medium">{{ auth('customer')->user()->whatsapp }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="icon-[tabler--calendar] me-3 size-5 text-gray-600"></span>
                        <span class="text-gray-600">Bergabung sejak</span>
                    </div>
                    <span class="font-medium">{{ auth('customer')->user()->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="icon-[tabler--user-check] me-3 size-5 text-gray-600"></span>
                        <span class="text-gray-600">Status Akun</span>
                    </div>
                    <div class="badge {{ auth('customer')->user()->is_active ? 'badge-success' : 'badge-error' }}">
                        {{ auth('customer')->user()->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-4 mt-6">
            <div
                class="card bg-white border-2 border-blue-200 shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer hover:border-blue-300">
                <div class="card-body p-5 text-center">
                    <div class="flex justify-center mb-2">
                        <span class="icon-[tabler--car] size-8 text-blue-500"></span>
                    </div>
                    <div class="text-3xl font-bold mb-1 text-blue-600">
                        {{ auth('customer')->user()->vehicles()->count() }}</div>
                    <div class="text-sm text-gray-600 font-medium">Kendaraan</div>
                </div>
            </div>
            <div
                class="card bg-white border-2 border-green-200 shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer hover:border-green-300">
                <div class="card-body p-5 text-center">
                    <div class="flex justify-center mb-2">
                        <span class="icon-[tabler--clock] size-8 text-green-500"></span>
                    </div>
                    <div class="text-3xl font-bold mb-1 text-green-600">
                        {{ auth('customer')->user()->queues()->count() }}</div>
                    <div class="text-sm text-gray-600 font-medium">Antrian</div>
                </div>
            </div>
            <div
                class="card bg-white border-2 border-purple-200 shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 cursor-pointer hover:border-purple-300">
                <div class="card-body p-5 text-center">
                    <div class="flex justify-center mb-2">
                        <span class="icon-[tabler--check] size-8 text-purple-500"></span>
                    </div>
                    <div class="text-3xl font-bold mb-1 text-purple-600">
                        {{ auth('customer')->user()->queues()->where('status', 'completed')->count() }}
                    </div>
                    <div class="text-sm text-gray-600 font-medium">Selesai</div>
                </div>
            </div>
        </div>


    </div>
</div>
