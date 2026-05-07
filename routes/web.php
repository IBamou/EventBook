<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Profile
    Route::prefix('/profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });

    // User Bookings
    Route::prefix('/bookings')->controller(BookingController::class)->group(function () {
        Route::get('/', 'index')->name('bookings.index');
        Route::get('/{booking}', 'show')->name('bookings.show');
    });

    Route::post('/events/{event}/book', [BookingController::class, 'store'])->name('bookings.book');

    // Organizer Events
    Route::middleware('organizer')->group(function () {
        Route::get('/events/archives', [EventController::class, 'archives'])->name('events.archives');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}/archive', [EventController::class, 'archive'])->name('events.archive');
        Route::delete('/events/{event}/restore', [EventController::class, 'restore'])->name('events.restore');
        Route::delete('/events/{event}/forceDelete', [EventController::class, 'forceDelete'])->name('events.forceDelete');
    });

    // Admin Routes
    Route::middleware('admin')->prefix('/admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('events', AdminEventController::class)->only(['index', 'destroy']);
        Route::resource('bookings', AdminBookingController::class)->only(['index', 'update']);
    });
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

require __DIR__.'/auth.php';
