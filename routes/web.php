<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;


// Users will be redirected to this route if not logged in
Route::get('/', function () {
    return redirect()->route('login');
});
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
    Route::middleware([\App\Http\Middleware\Student::class])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', \App\Livewire\student\Dashboard::class)->name('dashboard');
        Route::get('/projects', \App\Livewire\student\Projects\ProjectList::class)->name('projects.index');
        Route::get('/my-projects', \App\Livewire\student\Projects\MyProjects::class)->name('projects.self');
        Route::get('/my-project-request', \App\Livewire\student\Projects\ProjectRequest::class)->name('projects.requests');
        Route::get('/projects/create', \App\Livewire\student\Projects\CreateProject::class)->name('projects.create');
        Route::get('/projects/{project}', \App\Livewire\student\Projects\ShowProject::class)->name('projects.show');
        Route::get('/projects/{project}/edit', \App\Livewire\student\Projects\EditProject::class)->name('projects.edit');
        Route::get('/projects/{project}/meeting-log/create', \App\Livewire\student\Projects\CreateMeetingLog::class)->name('projects.createmeetinglog');
        Route::get('/projects/{project}/meeting-log/{meeting_log}', \App\Livewire\student\Projects\ShowMeetingLog::class)->name('projects.showmeetinglog');
        Route::get('/projects/{project}/meeting-log/{meeting_log}/edit', \App\Livewire\student\Projects\EditMeetingLog::class)->name('projects.editmeetinglog');
    });

    Route::middleware([\App\Http\Middleware\Supervisor::class])->prefix('supervisor')->name('supervisor.')->group(function () {
        Route::get('/dashboard', \App\Livewire\supervisor\Dashboard::class)->name('dashboard');
        Route::get('/projects', \App\Livewire\supervisor\Projects\ProjectList::class)->name('projects.index');
        Route::get('/my-projects', \App\Livewire\supervisor\Projects\MyProjects::class)->name('projects.self');
        Route::get('/projects/create', \App\Livewire\supervisor\Projects\CreateProject::class)->name('projects.create');
        Route::get('/projects/{project}', \App\Livewire\supervisor\Projects\ShowProject::class)->name('projects.show');
        Route::get('/projects/{project}/edit', \App\Livewire\supervisor\Projects\EditProject::class)->name('projects.edit');
        Route::get('/projects/{project}/meeting-log/create', \App\Livewire\supervisor\Projects\CreateMeetingLog::class)->name('projects.createmeetinglog');
        Route::get('/projects/{project}/meeting-log/{meeting_log}', \App\Livewire\supervisor\Projects\ShowMeetingLog::class)->name('projects.showmeetinglog');
        Route::get('/projects/{project}/meeting-log/{meeting_log}/edit', \App\Livewire\supervisor\Projects\EditMeetingLog::class)->name('projects.editmeetinglog');
    });

    Route::middleware([\App\Http\Middleware\Moderator::class])->prefix('moderator')->name('moderator.')->group(function () {
        Route::get('/dashboard', \App\Livewire\moderator\Dashboard::class)->name('dashboard');
        Route::get('/my-projects', \App\Livewire\moderator\Projects\MyProjects::class)->name('projects.self');
        Route::get('/projects/{project}', \App\Livewire\moderator\Projects\ShowProject::class)->name('projects.show');
        Route::get('/projects/{project}/meeting-log/{meeting_log}', \App\Livewire\moderator\Projects\ShowMeetingLog::class)->name('projects.showmeetinglog');
    });

//    Route::middleware([\App\Http\Middleware\Examiner::class])->prefix('examiner')->name('examiner.')->group(function () {
//        Route::get('/dashboard', \App\Livewire\examiner\Dashboard::class)->name('dashboard');
//    });

    Route::middleware([\App\Http\Middleware\Admin::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', \App\Livewire\admin\Dashboard::class)->name('dashboard');
        Route::get('/users', \App\Livewire\admin\Users\UserList::class)->name('users.index');
        Route::get('/users/create', \App\Livewire\admin\Users\CreateUser::class)->name('users.create');
        Route::get('/users/{user}/edit', \App\Livewire\admin\Users\EditUser::class)->name('users.edit');
        Route::get('/reports', \App\Livewire\admin\Reports::class)->name('reports.index');
    });

    Route::get('/profile', \App\Livewire\Shared\UpdateProfile::class)->name('profile');
});
