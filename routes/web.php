<?php

use App\Livewire\AdminDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/admin', AdminDashboard::class)->name('admin.dashboard');

Route::get('/components', function () {
    return view('components.flyonui-components');
})->name('components');
