<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="w-full max-w-4xl">
        <div class="bg-base-100 border-2 border-gray-300 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">{{ __('setup tenant') }}</h2>
                <p class="text-gray-600 text-center mb-10">{{ __('please fill before continue') }} </p>
                <form class="mt-6 space-y-4" novalidate wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="code" class="label">
                                <span class="label-text">{{ __('tenant code') }}</span>
                            </label>
                            <input id="code" wire:model="code" type="text" required
                                class="input input-bordered md:input-lg" placeholder="Kode SPBU">
                            @error('code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="label">
                                <span class="label-text">Nama SPBU</span>
                            </label>
                            <input id="name" wire:model="name" type="text" required
                                class="input input-bordered md:input-lg" placeholder="Nama SPBU">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="label">
                                <span class="label-text">No. Handphone</span>
                            </label>
                            <input id="phone" wire:model="phone" type="text" required
                                class="input input-bordered md:input-lg" placeholder="Nomor handphone">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="whatsapp" class="label">
                                <span class="label-text">Whatsapp</span>
                            </label>
                            <input id="whatsapp" wire:model="whatsapp" type="text"
                                class="input input-bordered md:input-lg" placeholder="Whatsapp">
                            @error('whatsapp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                        <div>
                            <label for="opening_time" class="label">
                                <span class="label-text">Jam Buka SPBU</span>
                            </label>
                            <input id="opening_time" wire:model="opening_time" type="text"
                                class="input input-bordered md:input-lg flatpickr" placeholder="Cth: 07:00"
                                data-time-only="true">
                            @error('opening_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="closing_time" class="label">
                                <span class="label-text">Jam Tutup SPBU</span>
                            </label>
                            <input id="closing_time" wire:model="closing_time" type="text"
                                class="input input-bordered md:input-lg flatpickr" placeholder="Cth: 14:00"
                                data-time-only="true">

                            @error('closing_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div>
                        <label for="url" class="label">
                            <span class="label-text">URL Subdomain</span>
                        </label>
                        <div class="join w-full">
                            <input id="url" wire:model="url" type="text" required
                                class="input input-bordered join-item md:input-lg w-full" placeholder="example">
                            <span
                                class="join-item bg-primary px-3 font-bold text-base-100 flex items-center">.{{ parse_url(config('app.url'), PHP_URL_HOST) }}</span>
                        </div>
                        <p class="text-gray-500 text-sm mt-1">URL subdomain digunakan untuk pelanggan mengambil
                            nomor
                            antrian dan tidak dapat diubah setelah tenant dibuat.</p>
                        @error('url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="address" class="label">
                            <span class="label-text">Alamat</span>
                        </label>
                        <textarea id="address" wire:model="address" rows="3" required
                            class="textarea textarea-bordered w-full md:textarea-lg" placeholder="Alamat SPBU"></textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 mt-6 sm:flex-row sm:justify-between">
                        <button wire:click="logout" class="btn btn-outline">
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-primary w-full sm:w-auto">
                            Simpan & Lanjutkan
                            <span class="icon-[tabler--arrow-right] size-4"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                &copy; 2025 Antrianku. All rights reserved.
            </p>
        </div>

    </div>
</div>
{{-- 

@push('scripts')
    <script>
        function initFlatpicker() {
            flatpickr(".flatpickr", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
            });
        }

        document.addEventListener("livewire:init", () => {
            initFlatpicker()
        });

        document.addEventListener("livewire:navigated", () => {
            initFlatpicker()
        });
    </script>
@endpush --}}
