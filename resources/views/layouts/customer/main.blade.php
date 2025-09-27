@extends('app')

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 px-4 py-6 pb-24 relative overflow-hidden">

        {{ $slot }}

    </div>
    @include('layouts.partials.bottom-navigation')
@endsection
