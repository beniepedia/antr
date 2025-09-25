<section class="bg-gradient-to-br from-primary/5 via-transparent to-primary/10 min-h-screen ">
    <div class="mx-auto max-w-6xl flex flex-col lg:flex-row items-center justify-center gap-6 lg:gap-20 px-6 py-8">

        <!-- Left: Hero copy -->
        <div class="order-2 space-y-4 text-center lg:order-1 lg:text-left lg:space-y-5">
            <div
                class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-primary">
                <span class="icon-[tabler--fuel] size-4"></span>
                <span class="text-sm">Pengisian Solar Cepat & Aman</span>
            </div>

            <h1 class="text-2xl font-bold leading-tight lg:text-3xl">Ambil Antrian Isi Solar di
            </h1>
            <p class="text-sm text-base-content/70 lg:text-base">Verifikasi via WhatsApp OTP. Proses antrian yang cepat
                dan mudah untuk isi solar.</p>

            <ul class="hidden mt-2 grid gap-3 sm:grid-cols-2 lg:max-w-md lg:grid">
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--shield-check] text-success size-5"></span>
                    <span>Verifikasi aman via OTP</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--smartphone] text-primary size-5"></span>
                    <span>Ramah mobile</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--clock] text-warning size-5"></span>
                    <span>Antrian cepat</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--fuel] text-info size-5"></span>
                    <span>Pengisian solar mudah</span>
                </li>
            </ul>
        </div>

        <!-- Right: Login card -->
        <div class="order-1 lg:order-2">
            <div
                class="card shadow-xl backdrop-blur bg-base-100/80 ring-1 ring-primary/20 rounded-2xl max-w-sm lg:max-w-md p-4">
                <div class="card-body space-y-4 lg:space-y-5">
                    @if ($errorMessage)
                        <div class="alert alert-error text-sm">
                            <span class="icon-[tabler--alert-circle] size-4"></span>
                            <span>{{ $errorMessage }}</span>
                        </div>
                    @endif

                    <div
                        class="avatar mb-7 avatar-placeholder bg-base-100 size-16 mx-auto rounded-full flex items-center justify-center  lg:size-18">
                        <img src="{{ asset('assets/img/logo-pertamina.png') }}" alt="Pertamina Logo"
                            class="size-7 lg:size-8 object-contain">
                    </div>


                    @if (!$otpSent)
                        <form wire:submit.prevent="sendOtp" class="space-y-6" novalidate>
                            <div class="text-center">
                                <h2 class="text-xl font-bold lg:text-2xl">Masuk Ambil Antrian</h2>
                                <p class="text-sm text-base-content/70 lg:text-base">Masukkan nomor WhatsApp Anda untuk
                                    mendapatkan antrian</p>
                            </div>
                            <div class="form-control">
                                <label class="form-label text-base font-semibold">Nomor WhatsApp</label>
                                <div class="relative mt-2">
                                    <input type="number" inputmode="numeric"
                                        class="input input-lg w-full text-base pl-10" placeholder="+62 8123 4567 890"
                                        wire:model.defer="phone" required>
                                    <span
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 icon-[tabler--brand-whatsapp] text-green-500 size-5"></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block text-sm lg:text-base btn-lg">
                                <span class="loading loading-spinner loading-sm" wire:loading></span>
                                <span class="icon-[tabler--send] size-5"></span>
                                <span class="ml-1 font-semibold">Kirim OTP</span>
                            </button>
                        </form>
                    @endif

                    @if ($otpSent)
                        <div class="text-center">
                            <h2 class="text-xl font-bold lg:text-2xl">Verifikasi OTP</h2>
                            <p class="text-sm text-base-content/70 lg:text-base">Masukkan kode OTP yang dikirim ke nomor
                                whatsapp</p>
                        </div>
                        <div class="divider text-sm lg:text-base" wire:poll.1s="decrementTimer">Verifikasi Kode OTP
                        </div>
                        <div class="space-y-3 lg:space-y-4">
                            <div class="flex justify-center gap-3 mb-8">
                                @for ($i = 0; $i < 4; $i++)
                                    <input id="otp-{{ $i }}"
                                        class="input input-bordered input-md lg:input-lg text-center w-12 mx-1"
                                        maxlength="1" pattern="[0-9]*" inputmode="numeric"
                                        wire:model.lazy="otp.{{ $i }}"
                                        oninput="handleOtpInput(this, {{ $i }})"
                                        onkeydown="handleOtpKeydown(this, event, {{ $i }})"
                                        onpaste="handleOtpPaste(event)">
                                @endfor

                            </div>
                            <button class="btn btn-success btn-block text-sm lg:text-base btn-lg" wire:click="verifyOtp"
                                wire:loading.attr="disabled">
                                <span class="icon-[tabler--shield-check] size-4"></span>
                                <span class="ml-1">Verifikasi</span>
                            </button>
                            <div class="flex items-center justify-between text-xs text-base-content/70 lg:text-sm">
                                <button type="button" class="btn btn-soft btn-primary btn-xs"
                                    wire:click="changeNumber">Ganti nomor</button>
                                @if ($resendTimer > 0)
                                    <button type="button" class="btn btn-text btn-xs lg:btn-sm" disabled>Kirim ulang
                                        dalam {{ str_pad($resendTimer, 2, '0', STR_PAD_LEFT) }} detik</button>
                                @else
                                    <button type="button" class="btn btn-soft btn-xs lg:btn-sm" wire:click="resendOtp"
                                        wire:loading.attr="disabled">
                                        <span>Kirim ulang</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                    <p class="text-center text-xs text-base-content/60 lg:text-sm">Dengan masuk, Anda menyetujui <a
                            class="link link-primary" href="#">Ketentuan Layanan</a> & <a
                            class="link link-primary" href="#">Kebijakan Privasi</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        function handleOtpInput(el, index) {
            const inputs = document.querySelectorAll('input[id^="otp-"]');

            if (el.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        }

        function handleOtpKeydown(el, event, index) {
            const inputs = document.querySelectorAll('input[id^="otp-"]');

            // kalau Backspace dan kosong → pindah balik
            if (event.key === 'Backspace' && el.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        }

        function handleOtpPaste(event) {
            event.preventDefault();
            const paste = (event.clipboardData || window.clipboardData).getData('text');
            const inputs = document.querySelectorAll('input[id^="otp-"]');

            if (!/^\d+$/.test(paste)) return; // hanya angka

            paste.split('').forEach((char, i) => {
                if (i < inputs.length) {
                    inputs[i].value = char;
                    inputs[i].dispatchEvent(new Event('input', {
                        bubbles: true
                    })); // sync ke Livewire
                }
            });

            // pindahkan fokus ke input terakhir terisi
            const filledIndex = Math.min(paste.length, inputs.length) - 1;
            if (filledIndex >= 0) {
                inputs[filledIndex].focus();
            }
        }
    </script>
@endpush
