<div class="space-y-2">
    <x-breadcumb :links="[['url' => route('tenant.dashboard'), 'label' => 'Dashboard'], ['url' => '#', 'label' => 'Pengaturan']]" />

    <style>
        @media print {
            .card {
                break-inside: avoid;
            }

            .btn {
                display: none;
            }

            body {
                font-size: 14px;
            }
        }
    </style>

    <div class="bg-base-100 rounded-lg shadow-sm p-6">
        <div class="flex-1">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <h1 class="text-xl font-bold">Pengaturan Tenant</h1>
                @if (!$editing)
                    <button wire:click="toggleEdit" class="btn btn-primary">Edit</button>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @if (!$editing)
                <div class="block md:hidden space-y-4 col-span-2">
                    @foreach ([
        'Kode Tenant' => $code,
        'Nama Tenant' => $name,
        'Domain URL' => $url,
        'WhatsApp' => $whatsapp ?: '-',
        'Telepon' => $phone ?: '-',
        'Jam Buka' => $opening_time ?: '-',
        'Jam Tutup' => $closing_time ?: '-',
        'Alamat' => $address ?: '-',
    ] as $label => $value)
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="font-semibold text-sm text-base-content/70">{{ $label }}</div>
                            <div class="text-base">{{ $value }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="hidden md:block overflow-x-auto col-span-2">
                    <table class="table table-zebra w-full text-sm md:text-base">
                        <tbody>
                            <tr>
                                <td class="font-semibold min-w-32">Kode Tenant</td>
                                <td>{{ $code }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold min-w-32">Nama Tenant</td>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold min-w-32">Domain URL</td>
                                <td>{{ $url }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold min-w-32">WhatsApp</td>
                                <td>{{ $whatsapp ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold min-w-32">Telepon</td>
                                <td>{{ $phone ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold min-w-32">Jam Buka</td>
                                <td>{{ $opening_time ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold min-w-32">Jam Tutup</td>
                                <td>{{ $closing_time ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold min-w-32">Alamat</td>
                                <td>{{ $address ?: '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="col-span-2">
                    <form wire:submit.prevent="updateSettings" class="space-y-6" novalidate>
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
                                    <span class="label-text">URL</span>
                                </label>
                                <input type="text" wire:model="url" class="input input-bordered" disabled />
                                <div class="text-sm text-gray-500 mt-1">URL tidak dapat diubah</div>
                            </div>

                            <div class="form-control md:col-span-2">
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

                        <div class="flex justify-end gap-2">
                            <button type="button" wire:click="toggleEdit" class="btn btn-ghost">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            @endif

            @if ($url && !$editing)
                <div class="col-span-2 lg:col-span-1">
                    <div class="card bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title text-center text-base-100">Kartu QR Code</h2>
                            <div class="flex flex-col items-center gap-4">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=10&data={{ make_url($url) }}"
                                    alt="QR Code" class="w-48 h-48 border rounded">
                                <p class="text-sm">Scan untuk akses</p>
                                <div class="text-center">
                                    <h3 class="text-lg font-bold">{{ $name }}</h3>
                                    <p class="text-xs">{{ $address ?: 'Alamat tidak tersedia' }}</p>
                                </div>
                            </div>
                            <div class="card-actions justify-center">
                                <button onclick="window.print()" class="btn btn-outline btn-white">Print</button>
                                <button wire:click="downloadQR" class="btn btn-white">Download QR</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
