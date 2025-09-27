<section class="bg-gradient-to-br from-primary/5 via-transparent to-primary/10 min-h-screen flex">
    <div class="mx-auto  flex flex-col lg:flex-row items-center justify-center gap-6 lg:gap-20 px-6 py-9">

        <!-- Left: Hero copy -->
        <div class="order-2 space-y-4 text-center lg:order-1 lg:text-left lg:space-y-5 lg:max-w-2xl">
            <div
                class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-primary">
                <span class="icon-[tabler--fuel] size-4"></span>
                <span class="text-sm">Sistem Antrian BBM Digital</span>
            </div>

            <h1 class="text-2xl font-bold leading-tight lg:text-3xl">
                Ambil Nomor Antrian Secara Online
            </h1>

            <p class="text-sm text-base-content/70 lg:text-base">
                Tidak perlu antri panjang di SPBU. Ambil nomor antrian lewat aplikasi, pantau status antrian
                secara real-time, dan isi solar sesuai giliran Anda.
            </p>

            <ul class="hidden grid gap-8 sm:grid-cols-2 lg:grid w-full">
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--list-numbers] text-primary size-8"></span>
                    <span>Nomor antrian online </span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--clock-hour-4] text-warning size-8"></span>
                    <span>Tidak buang waktu menunggu</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--brand-whatsapp] text-success size-10"></span>
                    <span>Verifikasi mudah via WhatsApp OTP</span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="icon-[tabler--map-pin] text-info size-8"></span>
                    <span>Pantau giliran dari mana saja</span>
                </li>
            </ul>

        </div>

        <!-- Right: Login card -->
        <div class="order-1 lg:order-2 ">
            <div class="shadow-xl  bg-base-100/80 ring-1 ring-primary/20 rounded-2xl max-w-lg lg:max-w-md p-4">
                <div class="card-body space-y-4 lg:space-y-5">

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
                        <form wire:submit.prevent="verifyOtp" class="space-y-6" novalidate
                            wire:poll.{{ $this->resendTimer > 0 ? '1000ms' : 'none' }}>
                            <div class="text-center">
                                <h2 class="text-xl font-bold lg:text-2xl">Verifikasi OTP</h2>
                                <p class="text-sm text-base-content/70 lg:text-base">Masukkan kode OTP yang dikirim ke
                                    nomor whatsapp</p>
                            </div>
                            <div class="divider text-sm lg:text-base">Verifikasi Kode OTP</div>
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
                                <button type="submit" class="btn btn-success btn-block text-sm lg:text-base btn-lg">
                                    <span class="icon-[tabler--shield-check] size-4"></span>
                                    <span class="ml-1">Verifikasi</span>
                                </button>
                                <div class="flex items-center justify-between text-xs text-base-content/70 lg:text-sm">
                                    <button type="button" class="btn btn-soft btn-primary btn-xs"
                                        wire:click="changeNumber">Ganti nomor</button>

                                    @if ($this->resendTimer > 0)
                                        <span>Kirim ulang dalam <span
                                                class="font-bold">{{ $this->formattedTimer }}</span></span>
                                    @else
                                        {{-- Tampilkan tombol Kirim Ulang --}}
                                        <button type="button" class="btn btn-soft btn-xs lg:btn-sm"
                                            wire:click="resendOtp" wire:loading.attr="disabled">
                                            <span>Kirim ulang</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
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
            if (event.key === 'Backspace' && el.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        }

        function handleOtpPaste(event) {
            event.preventDefault();
            const paste = (event.clipboardData || window.clipboardData).getData('text');
            const inputs = document.querySelectorAll('input[id^="otp-"]');
            if (!/^\d+$/.test(paste)) return;
            paste.split('').forEach((char, i) => {
                if (i < inputs.length) {
                    inputs[i].value = char;
                    inputs[i].dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
            });
            const filledIndex = Math.min(paste.length, inputs.length) - 1;
            if (filledIndex >= 0) {
                inputs[filledIndex].focus();
            }
        }
    </script>
@endpush
