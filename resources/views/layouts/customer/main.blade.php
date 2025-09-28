@extends('app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 pb-29 relative overflow-hidden">

        {{ $slot }}

    </div>
    @include('layouts.partials.bottom-navigation')
@endsection
