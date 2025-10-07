<div class="card">
    <div class="card-body md:px-10">
        @if ($status === 'pending')
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="flex justify-center mb-6">
                        <svg class="animate-spin h-16 w-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Sedang Mengkonfirmasi Pembayaran</h1>
                    <p class="text-lg text-gray-500 mb-6">Pembayaran sudah diterima. Mohon tunggu sebentar, kami
                        sedang memverifikasi pembayaran anda.</p>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-600">Jangan tutup halaman ini. Proses verifikasi biasanya memakan
                            waktu 1-2 menit.</p>
                    </div>
                </div>
            </div>
        @elseif($status === 'paid')
            <div class="text-center py-7">
                <div class="flex justify-center mb-4">
                    <svg class="h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-green-600">Pembayaran Berhasil!</h1>
                <p class="mt-4 text-gray-600">Pembayaran berhasil diverifikasi.<br>Paket langganan anda berhasil
                    diaktifkan. Terima Kasih!</p>
                <div class="mt-10">
                    <a href="{{ route('tenant.dashboard') }}" class="btn btn-primary" wire:navigate>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        @elseif($status === 'failed')
            <div class="text-center py-7">
                <div class="flex justify-center mb-4">
                    <svg class="h-16 w-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-red-600">Pembayaran Gagal</h1>
                <p class="mt-4 text-gray-600">Maaf, pembayaran Anda tidak dapat diproses. Silakan coba lagi.</p>
                <div class="mt-10">
                    <a href="{{ route('tenant.upgrade') }}" class="btn btn-error" wire:navigate>
                        Coba Lagi
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@script
    <script>
        let checkInterval = setInterval(() => {
            $wire.dispatch('check-payment')
        }, 5000);

        // misal Livewire kirim event kalau sudah berhasil
        Livewire.on('payment-response', () => {
            clearInterval(checkInterval);
        });
    </script>
@endscript
