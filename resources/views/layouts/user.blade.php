@extends('layouts.app')

@section('navbar')
    {{-- User specific navbar --}}
@endsection

@section('topbar')
    {{-- User specific topbar --}}
@endsection

@section('content')
    {{ $slot }}
@endsection