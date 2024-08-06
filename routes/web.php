<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\AdminAppointmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/book-an-appointment', [AppointmentController::class, 'bookAppointment'])->name('book.index');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    // Route for adding a product to the cart
    Route::post('/add-appointments/{id}', [AppointmentController::class, 'addAppointment'])->name('add.appointments');

    // Define a route for the form submission
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/remove/{id}', [AppointmentController::class, 'removeFromAppointments'])->name('remove.from.appointments');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::patch('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
});

Route::middleware('auth:admin')->group(function () {
    //Route::get('/profile', [LoginController::class, 'edit'])->name('admin.auth.edit');
    //Route::patch('/profile', [LoginController::class, 'update'])->name('admin.auth.update');
    //Route::delete('/profile', [LoginController::class, 'destroy'])->name('admin.auth.destroy');

    Route::get('/admin/appointments', [AdminAppointmentController::class, 'index'])->name('admin.index');

    // Define a route for the form submission
    Route::get('/admin/appointments/{id}', [AdminAppointmentController::class, 'show'])->name('admin.show');
    Route::post('/admin/appointments', [AdminAppointmentController::class, 'store'])->name('admin.store');
    //Route::post('/appointments/remove/{id}', [AdminAppointmentController::class, 'removeFromAppointments'])->name('remove.from.appointments');
    Route::get('/admin/appointments/{id}/edit', [AdminAppointmentController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/appointments/{id}', [AdminAppointmentController::class, 'update'])->name('admin.update');

    Route::get('/admin/users', [AdminAppointmentController::class, 'showAllUsers'])->name('admin.allusers');
});



require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
