<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;


// Users will be redirected to this route if not logged in
Route::get('/login', Login::class)->name('login');

// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Livewire\Dashboard::class)->name('dashboard');

    Route::get('/users', \App\Livewire\Users\UserList::class)->name('users.index');
    Route::get('/users/create', \App\Livewire\Users\CreateUser::class)->name('users.create');
    Route::get('/users/{user}/edit', \App\Livewire\Users\EditUser::class)->name('users.edit');

    Route::get('/projects', \App\Livewire\Projects\ProjectList::class)->name('projects.index');
});
