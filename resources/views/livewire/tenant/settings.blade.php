<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengaturan Tenant</h1>
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
                    <span class="label-text">Kontak Person</span>
                </label>
                <input type="text" wire:model="contact_person" class="input input-bordered" />
                @error('contact_person')
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