@extends('app')

@section('content')
    <div class="bg-base-200 flex min-h-screen flex-col">

        @include('layouts.partials.tenant-topbar')
        @include('layouts.partials.tenant-sidebar')

        <div class="flex grow flex-col lg:ps-75">
            <!-- ---------- MAIN CONTENT ---------- -->
            <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-4">
                <div class="grid grid-cols-1 gap-6">
                    {{ $slot }}
                </div>
            </main>
            <!-- ---------- END MAIN CONTENT ---------- -->

            <!-- ---------- FOOTER CONTENT ---------- -->
            <footer class="bg-base-100">
                <div class="mx-auto h-14 w-full max-w-7xl px-6"></div>
            </footer>
            <!-- ---------- END FOOTER CONTENT ---------- -->
        </div>
    </div>
@endsection
