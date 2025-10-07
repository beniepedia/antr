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
                             class="grow @error('password_confirmation') is-invalid @enderror" placeholder="••••••••" />
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
                     <a href="{{ route('login') }}" wire:navigate class="font-medium text-blue-600 hover:text-blue-500">
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
