@extends('app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-50 p-4">
        {{ $slot }}
    </div>
@endsection
