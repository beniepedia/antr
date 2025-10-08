 <div class="">
     <x-breadcumb :links="[
         ['url' => route('tenant.dashboard'), 'label' => 'Dashboard'],
         ['url' => route('tenant.karyawan'), 'label' => 'Karyawan'],
         ['url' => '#', 'label' => 'Detail'],
     ]" />

     <div
         class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 shadow bg-base-100 p-4 rounded-lg">
         <h1 class="text-xl text-base-content/80 w-full font-bold">
             Detail Karyawan
         </h1>
         <div class="flex gap-3 flex-col lg:flex-row w-full  justify-end">

             <a href="{{ route('tenant.karyawan') }}" class="btn btn-text">
                 <span class="icon-[tabler--arrow-left] size-4 mr-2" wire:navigate></span>
                 Kembali
             </a>

             <a href="{{ route('tenant.karyawan.edit', $karyawan->id) }}" wire:navigate class="btn btn-warning">
                 <span class="icon-[tabler--edit] size-4 mr-2"></span>
                 Edit
             </a>
         </div>
     </div>
     <div class="divider my-4"></div>

     <!-- Main Layout -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
         <!-- Profile Sidebar -->
         <div class="lg:col-span-1 space-y-8">
             <div class="card bg-base-100 shadow border-0 ">
                 <div class="card-body items-center text-center p-6">
                     <div class="avatar mb-6">
                         <div class="w-28 h-28 rounded-full shadow-lg">
                             @if ($karyawan->profile?->avatar)
                                 <img src="{{ asset('storage/' . $karyawan->profile->avatar) }}"
                                     alt="Avatar {{ $karyawan->name }}" class="object-cover" />
                             @else
                                 <img src="{{ asset('assets/img/default_avatar.png') }}"
                                     alt="Avatar {{ $karyawan->name }}" class="object-cover" />
                             @endif
                         </div>
                     </div>
                     <h2 class="card-title text-xl font-semibold">{{ $karyawan->name }}</h2>
                     <p class="text-base-content/70 text-sm">{{ $karyawan->email }}</p>
                     <div class="flex flex-col gap-2 mt-4 w-full items-center">
                         <div class="badge badge-primary badge-lg">
                             {{ \App\Enums\PositionEnum::from($karyawan->profile?->position ?? 'operator')->label() }}
                         </div>
                         <div
                             class="badge {{ $karyawan->profile?->status == 'active' ? 'badge-success' : 'badge-warning' }} badge-lg">
                             {{ $karyawan->profile?->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Statistics -->
             <div class="card bg-base-100 shadow border-0 hover:shadow-md transition-shadow">
                 <div class="card-body p-4">
                     <h3 class="card-title text-lg mb-4 text-info">
                         <span class="icon-[tabler--chart-bar] size-6 mr-3"></span>
                         Statistik
                     </h3>
                     <div class="">
                         <div class="stat">
                             <div class="stat-figure text-primary">
                                 <span class="icon-[tabler--users] size-10"></span>
                             </div>
                             <div class="stat-title">Total Antrian Dilayani</div>
                             <div class="stat-value text-primary text-lg">{{ $karyawan->servedQueues()->count() }}
                             </div>
                         </div>
                         <div class="stat">
                             <div class="stat-figure text-info">
                                 <span class="icon-[tabler--clock] size-10"></span>
                             </div>
                             <div class="stat-title">Antrian Aktif</div>
                             <div class="stat-value text-info text-lg">
                                 {{ $karyawan->servedQueues()->whereIn('status', ['called'])->count() }}</div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Details Content -->
         <div class="lg:col-span-2 space-y-8">
             <!-- Personal Information - Full Width -->
             <div class="card bg-base-100 shadow border-0 hover:shadow-md transition-shadow">
                 <div class="card-body p-6">
                     <h3 class="card-title text-lg mb-6 text-primary">
                         <span class="icon-[tabler--user] size-6 mr-3"></span>
                         Informasi Pribadi
                     </h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                             <span class="font-medium mb-1 sm:mb-0">Nama Lengkap:</span>
                             <span>{{ $karyawan->name }}</span>
                         </div>
                         <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                             <span class="font-medium mb-1 sm:mb-0">Email:</span>
                             <span>{{ $karyawan->email }}</span>
                         </div>
                         <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                             <span class="font-medium mb-1 sm:mb-0">ID Karyawan:</span>
                             <span>{{ $karyawan->profile?->employee_id ?? '-' }}</span>
                         </div>
                         <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                             <span class="font-medium mb-1 sm:mb-0">Jabatan:</span>
                             <span>{{ match ($karyawan->profile?->position ?? 'operator') {
                                 'operator' => 'Operator',
                                 'supervisor' => 'Supervisor',
                                 'manager' => 'Manager',
                                 default => 'Operator',
                             } }}</span>
                         </div>
                         <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                             <span class="font-medium mb-1 sm:mb-0">WhatsApp:</span>
                             <span>{{ $karyawan->profile?->whatsapp ?? '-' }}</span>
                         </div>
                         <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                             <span class="font-medium mb-1 sm:mb-0">Alamat:</span>
                             <span>{{ $karyawan->profile?->address ?? '-' }}</span>
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Employment and Account Side by Side -->
             <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                 <!-- Employment Information -->
                 <div class="card bg-base-100 shadow border-0 hover:shadow-md transition-shadow">
                     <div class="card-body p-6">
                         <h3 class="card-title text-lg mb-6 text-secondary">
                             <span class="icon-[tabler--building] size-6 mr-3"></span>
                             Informasi Kepegawaian
                         </h3>
                         <div class="space-y-4">
                             <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                                 <span class="font-medium mb-1 sm:mb-0">Tanggal Mulai Kerja:</span>
                                 <span>{{ $karyawan->profile?->hire_date ? $karyawan->profile->hire_date->format('d M Y') : '-' }}</span>
                             </div>
                             <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                                 <span class="font-medium mb-1 sm:mb-0">Status:</span>
                                 <span>
                                     <span
                                         class="badge {{ $karyawan->profile?->status == 'active' ? 'badge-success' : 'badge-warning' }}">
                                         {{ $karyawan->profile?->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                     </span>
                                 </span>
                             </div>
                             <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                                 <span class="font-medium mb-1 sm:mb-0">Nomor Lisensi:</span>
                                 <span>{{ $karyawan->profile?->license_number ?? '-' }}</span>
                             </div>
                             <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                                 <span class="font-medium mb-1 sm:mb-0">Tahun Pengalaman:</span>
                                 <span>{{ $karyawan->profile?->experience_years ?? '-' }} tahun</span>
                             </div>
                         </div>
                     </div>
                 </div>

                 <!-- Account Information -->
                 <div class="card bg-base-100 shadow border-0 hover:shadow-md transition-shadow">
                     <div class="card-body p-6">
                         <h3 class="card-title text-lg mb-6 text-accent">
                             <span class="icon-[tabler--shield] size-6 mr-3"></span>
                             Informasi Akun
                         </h3>
                         <div class="space-y-4">
                             <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                                 <span class="font-medium mb-1 sm:mb-0">Role:</span>
                                 <span class="badge badge-primary">{{ ucfirst($karyawan->role) }}</span>
                             </div>
                             <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                                 <span class="font-medium mb-1 sm:mb-0">Bergabung:</span>
                                 <span>{{ $karyawan->created_at->format('d M Y') }}</span>
                             </div>
                             <div class="flex flex-col sm:flex-row sm:justify-between py-1">
                                 <span class="font-medium mb-1 sm:mb-0">Terakhir Update:</span>
                                 <span>{{ $karyawan->updated_at->format('d M Y H:i') }}</span>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
