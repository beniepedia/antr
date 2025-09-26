<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Karyawan</h1>
        <div class="flex gap-2">
            <a href="/karyawan/{{ $karyawan->id }}/edit" class="btn btn-outline btn-info">
                <span class="icon-[tabler--edit] size-4 mr-2"></span>
                Edit
            </a>
            <a href="{{ route('tenant.karyawan') }}" class="btn btn-outline">
                <span class="icon-[tabler--arrow-left] size-4 mr-2"></span>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body items-center text-center">
                    <div class="avatar mb-4">
                        <div class="w-24 h-24 rounded-full">
                            @if ($karyawan->profile?->avatar)
                                <img src="{{ asset('storage/' . $karyawan->profile->avatar) }}"
                                    alt="Avatar {{ $karyawan->name }}" class="object-cover" />
                            @else
                                <div class="bg-gray-300 w-full h-full flex items-center justify-center">
                                    <span class="text-gray-600 text-2xl font-bold">
                                        {{ substr($karyawan->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <h2 class="card-title">{{ $karyawan->name }}</h2>
                    <p class="text-base-content/70">{{ $karyawan->email }}</p>
                    <div class="badge badge-outline mt-2">
                        {{ \App\Enums\PositionEnum::tryFrom($karyawan->profile?->position ?? 'operator')?->label() ?? 'Operator' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-4">
                            <span class="icon-[tabler--user] size-5 mr-2"></span>
                            Informasi Pribadi
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium">Nama Lengkap:</span>
                                <span>{{ $karyawan->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Email:</span>
                                <span>{{ $karyawan->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">ID Karyawan:</span>
                                <span>{{ $karyawan->profile?->employee_id ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Jabatan:</span>
                                <span>{{ \App\Enums\PositionEnum::tryFrom($karyawan->profile?->position ?? 'operator')?->label() ?? 'Operator' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">WhatsApp:</span>
                                <span>{{ $karyawan->profile?->whatsapp ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Alamat:</span>
                                <span>{{ $karyawan->profile?->address ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-4">
                            <span class="icon-[tabler--building] size-5 mr-2"></span>
                            Informasi Kepegawaian
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium">Tanggal Mulai Kerja:</span>
                                <span>{{ $karyawan->profile?->hire_date ? $karyawan->profile->hire_date->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Status:</span>
                                <span>
                                    <span
                                        class="badge {{ $karyawan->profile?->status == 'active' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $karyawan->profile?->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Nomor Lisensi:</span>
                                <span>{{ $karyawan->profile?->license_number ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Tahun Pengalaman:</span>
                                <span>{{ $karyawan->profile?->experience_years ?? '-' }} tahun</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-4">
                            <span class="icon-[tabler--shield] size-5 mr-2"></span>
                            Informasi Akun
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium">Role:</span>
                                <span class="badge badge-primary">{{ ucfirst($karyawan->role) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Bergabung:</span>
                                <span>{{ $karyawan->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Terakhir Update:</span>
                                <span>{{ $karyawan->updated_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics (if needed in future) -->
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-4">
                            <span class="icon-[tabler--chart-bar] size-5 mr-2"></span>
                            Statistik
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium">Total Antrian Dilayani:</span>
                                <span class="text-lg font-bold text-primary">
                                    {{ $karyawan->servedQueues()->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Antrian Aktif:</span>
                                <span class="text-lg font-bold text-info">
                                    {{ $karyawan->servedQueues()->whereIn('status', ['called'])->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
