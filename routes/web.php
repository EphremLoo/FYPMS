<?php

use App\Livewire\Login;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


// Users will be redirected to this route if not logged in
Route::get('/', Login::class)->name('login');

// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Volt::route('/users', 'users.index')->name('users.index');
    Route::get('/projects', \App\Livewire\ListProject::class)->name('projects.index');
});
