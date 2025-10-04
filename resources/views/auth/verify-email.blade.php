<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Email Verification') }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email, we will gladly send you another.') }}
            </div>

            @if (session('resent'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit" class="btn btn-primary w-full">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>