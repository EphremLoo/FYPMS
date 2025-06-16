<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;


// Users will be redirected to this route if not logged in
Route::get('/login', Login::class)->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');

// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', \App\Livewire\student\Dashboard::class)->name('dashboard');

//        Route::get('/users', \App\Livewire\Users\UserList::class)->name('users.index');
//        Route::get('/users/create', \App\Livewire\Users\CreateUser::class)->name('users.create');
//        Route::get('/users/{user}/edit', \App\Livewire\Users\EditUser::class)->name('users.edit');

        Route::get('/projects', \App\Livewire\student\Projects\ProjectList::class)->name('projects.index');
        Route::get('/my-projects', \App\Livewire\student\Projects\MyProjects::class)->name('projects.self');
        Route::get('/my-project-request', \App\Livewire\student\Projects\ProjectRequest::class)->name('projects.requests');
        Route::get('/projects/create', \App\Livewire\student\Projects\CreateProject::class)->name('projects.create');
        Route::get('/projects/{project}/edit', \App\Livewire\student\Projects\EditProject::class)->name('projects.edit');
        Route::get('/projects/{project}', \App\Livewire\student\Projects\ShowProject::class)->name('projects.show');
    })->middleware('student');
});
