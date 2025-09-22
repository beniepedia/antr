<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="w-full max-w-4xl">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Setup Akun Tenant</h2>
                <p class="text-gray-600 text-center mb-6">Lengkapi informasi SPBU Anda untuk memulai.</p>
    <form class="mt-8 space-y-6" novalidate wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="code" class="label">
                    <span class="label-text">Kode SPBU</span>
                </label>
                <input id="code" wire:model="code" type="text" required class="input input-bordered md:input-lg"
                    placeholder="Kode SPBU">
                @error('code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="name" class="label">
                    <span class="label-text">Nama SPBU</span>
                </label>
                <input id="name" wire:model="name" type="text" required class="input input-bordered md:input-lg"
                    placeholder="Nama SPBU">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
                        <div>
                            <label for="contact_person" class="label">
                                <span class="label-text">Nomor HP</span>
                            </label>
                            <input id="contact_person" wire:model="contact_person" type="tel" required
                                class="input input-bordered md:input-lg" placeholder="Nomor HP">
                            @error('contact_person')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="label">
                                <span class="label-text">Telepon</span>
                            </label>
                            <input id="phone" wire:model="phone" type="text" class="input input-bordered md:input-lg"
                                placeholder="Telepon">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
        </div>
        <div class="mt-4">
            <label for="address" class="label">
                <span class="label-text">Alamat</span>
            </label>
            <textarea id="address" wire:model="address" rows="3" required class="textarea textarea-bordered w-full md:textarea-lg"
                placeholder="Alamat SPBU"></textarea>
            @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-4">
            <label for="url" class="label">
                <span class="label-text">URL Subdomain</span>
            </label>
            <div class="join w-full">
                <input id="url" wire:model="url" type="text" required class="input input-bordered join-item md:input-lg flex-1"
                    placeholder="tes">
                <span class="join-item bg-base-200 px-3 flex items-center">.{{ parse_url(config('app.url'), PHP_URL_HOST) }}</span>
            </div>
            <p class="text-gray-500 text-sm mt-1">URL subdomain digunakan untuk pelanggan mengambil nomor antrian dan tidak dapat diubah setelah tenant dibuat.</p>
            @error('url')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-4 mt-4 sm:flex-row sm:justify-between">
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
