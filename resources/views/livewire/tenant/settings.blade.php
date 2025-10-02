<div class="space-y-2">
    <x-breadcumb :links="[['url' => route('tenant.dashboard'), 'label' => 'Dashboard'], ['url' => '#', 'label' => 'Pengaturan']]" />

    <div class="bg-base-100 rounded-lg shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-xl font-bold">Pengaturan Tenant</h1>
        </div>

    <form wire:submit.prevent="updateSettings" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Kode Tenant</span>
                </label>
                <input type="text" wire:model="code" class="input input-bordered" disabled />
                <div class="text-sm text-gray-500 mt-1">Kode tenant tidak dapat diubah</div>
            </div>
            
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama Tenant *</span>
                </label>
                <input type="text" wire:model="name" class="input input-bordered" required />
                @error('name')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-control">
                <label class="label">
                    <span class="label-text">WhatsApp</span>
                </label>
                <input type="text" wire:model="whatsapp" class="input input-bordered" />
                @error('whatsapp')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Telepon</span>
                </label>
                <input type="text" wire:model="phone" class="input input-bordered" />
                @error('phone')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Jam Buka</span>
                </label>
                <input type="time" wire:model="opening_time" class="input input-bordered" />
                @error('opening_time')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Jam Tutup</span>
                </label>
                <input type="time" wire:model="closing_time" class="input input-bordered" />
                @error('closing_time')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control md:col-span-2">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <textarea wire:model="address" class="textarea textarea-bordered" rows="3"></textarea>
                @error('address')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
    </div>
</div>