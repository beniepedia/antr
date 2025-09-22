@extends('layouts.app')

@section('navbar')
    @include('layouts.partials.tenant-navbar')
@endsection

@section('topbar')
    @include('layouts.partials.admin-topbar')
@endsection

@section('content')
    {{ $slot }}
@endsection
