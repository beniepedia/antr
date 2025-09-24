<div>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-violet-500 via-purple-500 to-indigo-600 text-white py-8 mb-6 rounded-2xl">
        <div class="max-w-4xl mx-auto text-center px-4">
            <div class="mb-6">
                <span class="icon-[tabler--crown] size-16 mx-auto block mb-4 opacity-90"></span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Upgrade Paket Langganan Anda</h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8">Dapatkan fitur premium dan kapasitas lebih besar untuk bisnis Anda</p>

        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4">
        <!-- Pricing Cards -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 mb-12">
            @foreach($plans as $index => $plan)
                <div class="card rounded-2xl {{ $selectedPlan == $plan->id ? 'border-primary ring-2 ring-primary ring-opacity-50 shadow-2xl scale-105' : 'border-gray-200 hover:shadow-xl hover:scale-102' }} transition-all duration-300 bg-white">
                    <div class="card-body p-6">
                        @if($index == 1)
                            <div class="badge badge-primary mb-4">Paling Populer</div>
                        @endif
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="icon-[tabler--package] size-8 text-white"></span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>
                            <div class="mt-4">
                                <span class="text-4xl font-bold text-primary">Rp {{ number_format($plan->price ?? 0) }}</span>
                                <span class="text-gray-500">/bulan</span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3">
                                <span class="icon-[tabler--users] size-5 text-green-500"></span>
                                <span class="text-sm">Maksimal {{ $plan->max_users ?? 100 }} pengguna</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="icon-[tabler--list] size-5 text-blue-500"></span>
                                <span class="text-sm">Antrian {{ $plan->max_queues ?? 'Unlimited' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="icon-[tabler--chart-bar] size-5 text-purple-500"></span>
                                <span class="text-sm">Laporan & Analitik</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="icon-[tabler--headphones] size-5 text-orange-500"></span>
                                <span class="text-sm">Dukungan {{ $plan->support_level ?? 'Standar' }}</span>
                            </div>
                        </div>

                        <div class="text-center">
                            @if($selectedPlan == $plan->id)
                                <button class="btn btn-primary w-full btn-lg gap-2 shadow-lg" wire:click="proceedToPayment">
                                    <span class="icon-[tabler--credit-card] size-5"></span>
                                    Lanjut ke Pembayaran
                                </button>
                            @else
                                <button class="btn {{ $index == 1 ? 'btn-primary' : 'btn-outline btn-primary' }} w-full btn-lg gap-2" wire:click="selectPlan({{ $plan->id }})">
                                    <span class="icon-[tabler--check] size-5"></span>
                                    Pilih Paket Ini
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- FAQ Section -->
        <div class="bg-gray-50 rounded-2xl p-8 mb-12">
            <h2 class="text-2xl font-bold text-center mb-8">Pertanyaan Umum</h2>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <h3 class="font-semibold mb-2">Apakah bisa downgrade paket?</h3>
                    <p class="text-gray-600 text-sm">Ya, Anda bisa downgrade paket kapan saja, perubahan akan berlaku di periode billing berikutnya.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Bagaimana cara pembayaran?</h3>
                    <p class="text-gray-600 text-sm">Pembayaran dilakukan secara otomatis via kartu kredit atau transfer bank bulanan.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Apakah ada diskon untuk pembayaran tahunan?</h3>
                    <p class="text-gray-600 text-sm">Ya, dapatkan diskon 20% untuk pembayaran tahunan pada paket tertentu.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Dukungan teknis 24/7?</h3>
                    <p class="text-gray-600 text-sm">Dukungan premium tersedia 24/7 via chat dan email untuk paket tertentu.</p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center">
            <a href="{{ route('tenant.dashboard') }}" class="btn btn-soft btn-secondary btn-lg gap-2">
                <span class="icon-[tabler--arrow-left] size-5"></span>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>