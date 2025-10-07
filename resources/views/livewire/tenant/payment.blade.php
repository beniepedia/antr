<div class="">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-blue-600 text-white py-12 mb-8 rounded-2xl shadow-lg">
        <div class="max-w-2xl mx-auto text-center px-4">
            <div class="mb-4">
                <span class="icon-[tabler--credit-card] size-12 mx-auto block"></span>
            </div>
            <h1 class="text-3xl font-bold mb-2">Pembayaran</h1>
            <p class="text-green-100">Lengkapi informasi pembayaran untuk mengaktifkan paket premium Anda</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- Plan Summary -->
        <div class="card mb-8 rounded-2xl shadow-lg border">
            <div class="card-body ">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="card-title text-xl">Ringkasan Paket</h2>
                    <span class="icon-[tabler--package] size-6 text-primary"></span>
                </div>
                <div class="md:bg-gray-100 md:p-6 rounded-lg mb-4">
                    <div class="flex flex-col gap-x-6 md:flex-row justify-between items-center mb-2">
                        <div class="mb-8 md:mb-0">
                            <h3 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h3>
                            <p class="text-gray-600 ">
                                {{ $plan->description ?? '' }}</p>
                        </div>
                        <div
                            class="text-center py-3 bg-gray-100 md:bg-gray-100 border-b-3 border-indigo-400 md:border-none w-full md:w-auto">
                            <p class="text-3xl font-bold text-primary text-nowrap">Rp
                                {{ number_format($plan->price ?? 0) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Discount Section -->
                <div class="mb-4">
                    <label class="label">
                        <span class="label-text font-medium">Kode Promo (Opsional)</span>
                    </label>
                    <div class="flex flex-col md:flex-row gap-2">
                        <div class="w-full">
                            <input type="text" class="input " wire:model="discountCode"
                                placeholder="Masukkan kode promo">
                            @error('coupon')
                                <h6 class="text-red-600 mt-2 ml-2 text-sm ">{{ $message }}</h6>
                            @enderror
                            @if ($discountAmount > 0)
                                <div class="text-green-600 text-sm mt-2 flex items-center gap-1">
                                    <span class="icon-[tabler--circle-check] size-4"></span>
                                    Kode promo berhasil diterapkan: Rp {{ number_format($discountAmount) }}
                                </div>
                            @endif
                        </div>

                        <button type="button" class="btn btn-primary" wire:click="applyDiscount">
                            <span class="icon-[tabler--tag] size-4"></span>
                            Terapkan
                        </button>
                    </div>

                </div>

                <hr class="mt-5">
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">Subtotal</span>
                        <span class="text-lg text-gray-900">Rp {{ number_format($plan->price ?? 0) }}</span>
                    </div>
                    @if ($discountAmount > 0)
                        <div class="flex justify-between items-center text-green-600">
                            <span class="font-semibold">Diskon</span>
                            <span>- Rp {{ number_format($discountAmount) }}</span>
                        </div>
                    @endif
                    <hr class="my-2">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-primary">Rp
                            {{ number_format(($plan->price ?? 0) - $discountAmount) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information Form -->
        <div class="card rounded-2xl shadow-lg border">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="card-title text-xl">Informasi Pembayaran</h2>
                    <span class="icon-[tabler--shield-check] size-6 text-green-500"></span>
                </div>
                <form wire:submit.prevent="processPayment" class="space-y-6">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="label">
                                <span class="label-text font-medium">Nama Lengkap</span>
                            </label>
                            <input type="text" class="input  w-full " wire:model="fullName"
                                placeholder="Masukkan nama lengkap anda">
                            @error('fullName')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="label">
                                <span class="label-text font-medium">No. Handphone</span>
                            </label>
                            <input type="text" class="input  w-full " wire:model="phone"
                                placeholder="Masukkan nomor handphone">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="label">
                            <span class="label-text font-medium">Email</span>
                        </label>
                        <input type="email" class="input  w-full " wire:model="email" placeholder="Masukkan email">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="alert alert-success alert-soft rounded-lg">
                        <span class="icon-[tabler--lock] size-5"></span>
                        <div>
                            <p class="font-medium">Pembayaran Aman & Terjamin</p>
                            <p class="text-sm">Data Anda dilindungi dengan enkripsi 256-bit. Kami tidak menyimpan
                                informasi kartu kredit.</p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 pt-4">
                        <button type="submit"
                            class="btn btn-primary w-full md:flex-1 btn-lg shadow-lg order-1 md:order-2">
                            <span class="icon-[tabler--credit-card] size-5"></span>
                            Proses Pembayaran
                        </button>
                        <a href="{{ route('tenant.upgrade') }}" wire:navigate
                            class="btn btn-outline btn-secondary w-full md:flex-1 btn-lg order-2 md:order-1">
                            <span class="icon-[tabler--arrow-left] size-5"></span>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>

<!-- Duitku POP Script -->
{{-- @push('scripts')
    <script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-payment-popup', (event) => {

                checkout.process(event.reference, {
                    defaultLanguage: "id",
                    successEvent: function(result) {
                        window.location.href = '{{ route('tenant.dashboard') }}';
                    },
                    pendingEvent: function(result) {
                        console.log('Payment Pending:', result);
                    },
                    errorEvent: function(result) {
                        console.log('Payment Error:', result);
                    },
                    closeEvent: function(result) {
                        console.log('Popup closed:', result);
                    }
                });
            });
        });
    </script>
@endpush --}}
