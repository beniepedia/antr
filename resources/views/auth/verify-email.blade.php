@extends('app')

@section('title', 'Verifikasi Email')

@section('content')
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
                    <h1 class="text-3xl font-bold text-white">Verifikasi Email</h1>
                    <p class="text-indigo-100 mt-2">Sistem Antrian Modern</p>
                </div>

                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Periksa Email Anda</h2>
                        <p class="text-gray-600">
                            Sebelum melanjutkan, silakan periksa folder inbox/spam email Anda untuk verifikasi email.
                        </p>
                    </div>

                    @if (session('resent'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        Tautan verifikasi baru telah dikirim ke alamat email Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                        @csrf

                        <button type="submit" class="btn btn-primary w-full">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Sudah verifikasi?
                            <a href="{{ route('tenant.dashboard') }}" wire:navigate
                                class="font-medium text-blue-600 hover:text-blue-500">
                                Kembali ke Dashboard
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
@endsection
