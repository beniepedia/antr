@extends('app')
@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-10">
        {{ $slot }}
    </div>
@endsection
