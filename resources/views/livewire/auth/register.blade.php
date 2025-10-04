<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-4">
    <!-- Enhanced Animated Background -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <!-- Floating Circles -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-blue-200 opacity-20 blur-3xl animate-pulse">
        </div>
        <div
            class="absolute top-3/4 right-1/4 w-48 h-48 rounded-full bg-indigo-200 opacity-20 blur-3xl animate-pulse delay-1000">
        </div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 rounded-full bg-purple-200 opacity-10 blur-3xl animate-pulse delay-2000">
        </div>

        <!-- Subtle Grid Pattern -->
        <div class="absolute top-0 left-0 w-full h-full opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#6366f1" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl overflow-hidden border border-white/50">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-center">
                <h1 class="text-3xl font-bold text-white">Antrianku</h1>
                <p class="text-indigo-100 mt-2">Sistem Antrian Modern</p>
            </div>

            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Buat Akun Baru</h2>
                <p class="text-gray-600 text-center mb-6">Bergabunglah dengan ribuan pengguna yang telah mempercayai
                    Antrianku untuk pengalaman antrian yang efisien dan modern.</p>

                <form wire:submit.prevent="register" novalidate>
                    <div class="mb-5">
                        <label for="name" class="sr-only">Nama Lengkap</label>
                        <div class="input">
                            <span class="icon-[tabler--user] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model.defer="name" type="text" id="name"
                                class="grow @error('name') is-invalid @enderror" placeholder="Nama Lengkap" />
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="sr-only">Email</label>
                        <div class="input">
                            <span class="icon-[tabler--mail] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model.defer="email" type="email" id="email"
                                class="grow @error('email') is-invalid @enderror" placeholder="email@contoh.com" />
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="sr-only">Password</label>
                        <div class="input">
                            <span class="icon-[tabler--key] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model.defer="password" type="password" id="password"
                                class="grow @error('password') is-invalid @enderror" placeholder="••••••••" />
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="sr-only">Konfirmasi Password</label>
                        <div class="input">
                            <span class="icon-[tabler--key] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model.defer="password_confirmation" type="password" id="password_confirmation"
                                class="grow @error('password_confirmation') is-invalid @enderror"
                                placeholder="••••••••" />
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center">
                            <input wire:model="terms" type="checkbox"
                                class="checkbox checkbox-primary @error('terms') is-invalid @enderror" id="terms"
                                required />
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-500">syarat
                                    dan ketentuan</a>
                            </label>
                        </div>
                        @error('terms')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        <span wire:loading class="loading loading-spinner"></span>
                        Daftar
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" wire:navigate
                            class="font-medium text-blue-600 hover:text-blue-500">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                &copy; 2025 Antrianku. All rights reserved.
            </p>
        </div>
    </div>
</div>
