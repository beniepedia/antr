<div class="max-w-xl mx-auto pt-19">
    <!-- Header -->
    <x-mobile-header title="Profil Saya" />

    <div class="px-3">
        <!-- Profile Card -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <!-- Profile Header -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="avatar">
                        <div class="w-16 rounded-full bg-primary text-primary-content">
                            <span class="icon-[tabler--user] size-8"></span>
                        </div>
                    </div>
                    <div>
                        <h2 class="card-title">{{ auth('customer')->user()->name }}</h2>
                        <p class="text-base-content/70">{{ auth('customer')->user()->whatsapp }}</p>
                    </div>
                </div>


                <!-- Form -->
                <form wire:submit="save" class="space-y-4">
                    <!-- Name -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nama Lengkap</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <span class="icon-[tabler--user] size-5 text-base-content/60"></span>
                            <input wire:model="name" type="text" class="grow"
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
                            <span class="label-text">Nomor WhatsApp</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <span class="icon-[tabler--brand-whatsapp] size-5 text-base-content/60"></span>
                            <input wire:model="whatsapp" type="text" class="grow" placeholder="6281234567890" />
                        </label>
                        @error('whatsapp')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary w-full">
                            <span wire:loading class="loading loading-spinner"></span>
                            <span wire:loading.remove>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg">
                <div class="card-body p-4 text-center">
                    <div class="text-2xl font-bold">{{ auth('customer')->user()->vehicles()->count() }}</div>
                    <div class="text-sm opacity-90">Kendaraan</div>
                </div>
            </div>
            <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg">
                <div class="card-body p-4 text-center">
                    <div class="text-2xl font-bold">{{ auth('customer')->user()->queues()->count() }}</div>
                    <div class="text-sm opacity-90">Antrian</div>
                </div>
            </div>
            <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg">
                <div class="card-body p-4 text-center">
                    <div class="text-2xl font-bold">
                        {{ auth('customer')->user()->queues()->where('status', 'completed')->count() }}
                    </div>
                    <div class="text-sm opacity-90">Selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>
