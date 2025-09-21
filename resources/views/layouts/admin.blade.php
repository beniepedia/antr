@extends('layouts.app')

@section('navbar')
    @include('layouts.partials.admin-navbar')
@endsection

@section('topbar')
    @include('layouts.partials.admin-topbar')
@endsection

@section('content')
    {{ $slot }}
@endsection