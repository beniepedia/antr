<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-center">
                <h1 class="text-3xl font-bold text-white">Antrianku</h1>
                <p class="text-indigo-100 mt-2">Sistem Antrian Modern</p>
            </div>

            <div class="p-8">
                <div class="space-y-4 mb-6">
                    <button type="button" class="btn btn-soft btn-primary btn-lg w-full">
                        <svg class="w-5 h-5 mr-2 text-red-500" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="currentColor"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="currentColor"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="currentColor"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Login dengan Google
                    </button>
                    <button type="button" class="btn btn-outline [--btn-color:#1877F2] btn-lg  w-full">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        Login dengan Facebook
                    </button>
                </div>

                <div class="divider mb-6">atau</div>

                <form wire:submit.prevent="login" novalidate>
                    <div class="mb-5">
                        <label for="email" class="sr-only">Email</label>
                        <div class="input input-lg">
                            <span class="icon-[tabler--mail] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model.defer="email" type="email" id="email" class="grow"
                                placeholder="email@contoh.com" />
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="sr-only">Password</label>
                        <div class="input input-lg">
                            <span class="icon-[tabler--key] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                            <input wire:model.defer="password" type="password" id="password" class="grow"
                                placeholder="••••••••" />
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input wire:model="remember" id="remember" type="checkbox"
                                class="checkbox checkbox-primary" />
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-full">
                        Masuk
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" wire:navigate
                            class="font-medium text-blue-600 hover:text-blue-500">
                            Daftar sekarang
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
