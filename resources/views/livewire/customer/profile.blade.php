<div class="min-h-screen ">
    <!-- Custom Header -->
    <div class="top-0 bg-base-100 rounded shadow">
        <div class="container mx-auto px-4 py-2 max-w-2xl">
            <div class="flex items-center justify-between">
                <a href="{{ route('customer.dashboard') }}">
                    <span class="icon-[tabler--arrow-left] size-5"></span>
                </a>
                <h1 class="text-xl font-semibold text-gray-900 absolute left-1/2 transform -translate-x-1/2">Profil Saya
                </h1>

            </div>
        </div>
    </div>

    <div class="container mx-auto py-8 max-w-2xl">

        <!-- Profile Card -->
        <div class="border border-gray-200 rounded-lg shadow-sm">
            <!-- Profile Info -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                        <span class="icon-[tabler--user] text-gray-600 size-8"></span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ auth('customer')->user()->name }}</h2>
                        <p class="text-gray-600">{{ auth('customer')->user()->whatsapp }}</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="p-6">
                @if (session()->has('message'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-md">
                        <div class="flex items-center">
                            <span class="icon-[tabler--circle-check] text-green-600 size-5 mr-2"></span>
                            <span class="text-green-800 text-sm">{{ session('message') }}</span>
                        </div>
                    </div>
                @endif

                <form wire:submit="save" class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="input">
                            <span class="icon-[tabler--user] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model="name" type="text" class="grow" id="name"
                                placeholder="Masukkan nama lengkap" />
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor WhatsApp
                        </label>
                        <div class="input">
                            <span
                                class="icon-[tabler--brand-whatsapp] text-gray-400 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model="whatsapp" type="text" class="grow" id="whatsapp"
                                placeholder="6281234567890" />
                        </div>
                        @error('whatsapp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary w-full">
                            <span wire:loading class="loading loading-spinner"></span>
                            <span wire:loading.remove>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="mt-8 grid grid-cols-3 gap-4">
            <div class="border border-gray-200 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ auth('customer')->user()->vehicles()->count() }}</div>
                <div class="text-sm text-gray-600">Kendaraan</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ auth('customer')->user()->queues()->count() }}</div>
                <div class="text-sm text-gray-600">Antrian</div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-purple-600">
                    {{ auth('customer')->user()->queues()->where('status', 'completed')->count() }}</div>
                <div class="text-sm text-gray-600">Selesai</div>
            </div>
        </div>
    </div>
</div>
