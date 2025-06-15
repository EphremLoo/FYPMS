<?php

use App\Livewire\Login;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


// Users will be redirected to this route if not logged in
Volt::route('/login', 'login')->name('login');

// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

Route::get('/', Login::class);
