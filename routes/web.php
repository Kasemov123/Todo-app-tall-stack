<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\AdminDashboard;

// Home page for visitors
Route::view('/', 'home')->name('home');

// User dashboard with tabs
Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin dashboard
Route::get('/admin/dashboard', AdminDashboard::class)
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
