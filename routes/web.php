<?php

use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [JobListingController::class, 'browse'])->name('home');

// Admin Secret Register
Route::get('/admin-setup/register',  [AdminRegisterController::class, 'showForm'])->name('admin.register.form');
Route::post('/admin-setup/register', [AdminRegisterController::class, 'register'])->name('admin.register');

require __DIR__.'/auth.php';

// Role redirect
Route::middleware('auth')->get('/dashboard', function () {
    return match(auth()->user()->role) {
        'admin'    => redirect()->route('admin.dashboard'),
        'employer' => redirect()->route('employer.dashboard'),
        default    => redirect()->route('jobseeker.dashboard'),
    };
})->name('dashboard');

// Profile (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Employer
Route::middleware(['auth', 'role:employer,admin'])->group(function () {
    Route::get('/employer/dashboard',                  [JobListingController::class, 'index'])->name('employer.dashboard');
    Route::get('/jobs/create',                         [JobListingController::class, 'create'])->name('jobs.create');
    Route::post('/jobs',                               [JobListingController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{jobListing}/edit',              [JobListingController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{jobListing}',                   [JobListingController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{jobListing}',                [JobListingController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/jobs/{jobListing}/applications',      [JobListingController::class, 'applications'])->name('jobs.applications');
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
}); // ← was missing

// Jobseeker
Route::middleware(['auth', 'role:jobseeker'])->group(function () {
    Route::get('/jobseeker/dashboard',             [DashboardController::class, 'jobseeker'])->name('jobseeker.dashboard');
    Route::post('/jobs/{jobListing}/apply',        [ApplicationController::class, 'store'])->name('applications.store');
}); // ← was missing

// Wildcard MUST come after all static /jobs/* routes
Route::get('/jobs/{jobListing}', [JobListingController::class, 'show'])->name('jobs.show');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                           [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/jobs',                                [AdminController::class, 'jobs'])->name('jobs');
    Route::delete('/jobs/{jobListing}',                [AdminController::class, 'deleteJob'])->name('jobs.delete');
    Route::patch('/jobs/{jobListing}/toggle',          [AdminController::class, 'toggleJob'])->name('jobs.toggle');
    Route::get('/users',                               [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}',                     [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{user}/role',                 [AdminController::class, 'updateRole'])->name('users.role');
    Route::get('/applications',                        [AdminController::class, 'applications'])->name('applications');
    Route::delete('/applications/{application}',       [AdminController::class, 'deleteApplication'])->name('applications.delete');
});