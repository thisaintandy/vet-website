<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Notification;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\Auth\AdminAppointmentController;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

//Verifying email by sending email to user
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('welcome');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('user-notify/{id}', [Notification::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/book-an-appointment', [AppointmentController::class, 'bookAppointment'])->name('book.index');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    // Route for adding an appointment
    Route::post('/add-appointments/{id}', [AppointmentController::class, 'addAppointment'])->name('add.appointments');

    // Define a route for the form submission
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::post('/appointments/remove/{id}', [AppointmentController::class, 'removeAppointment'])->name('remove.appointment');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::patch('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
});

Route::middleware('auth:admin')->group(function () {


    Route::get('/admin/profile', [LoginController::class, 'edit'])->name('admin.auth.edit');
    Route::patch('/admin/profile', [LoginController::class, 'update'])->name('admin.auth.update');
    Route::delete('/admin/profile', [LoginController::class, 'destroy'])->name('admin.auth.destroy');

    Route::get('/admin/appointments', [AdminAppointmentController::class, 'index'])->name('admin.index');

    // Define a route for the form submission
    Route::get('/admin/appointments/{id}', [AdminAppointmentController::class, 'show'])->name('admin.show');
    Route::post('/admin/appointments', [AdminAppointmentController::class, 'store'])->name('admin.store');
    Route::post('/admin/appointments/remove/{id}', [AdminAppointmentController::class, 'removeFromAppointments'])->name('remove.from.appointments');
    Route::get('/admin/appointments/{id}/edit', [AdminAppointmentController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/appointments/{id}', [AdminAppointmentController::class, 'update'])->name('admin.update');


    Route::get('/admin/users', [AdminAppointmentController::class, 'showAllUsers'])->name('admin.allusers');
    Route::post('/admin/users/remove/{id}', [AdminAppointmentController::class, 'removeUser'])->name('delete.user');
    Route::get('/admin/users/edit/{id}', [AdminAppointmentController::class, 'editUser'])->name('edit.user');
    Route::patch('/admin/users/{id}/update', [AdminAppointmentController::class, 'updateUser'])->name('update.user');

    Route::post('/admin/notify/{id}', [AdminAppointmentController::class, 'notifyUser'])->name('notify.user');
});

Route::get('/full-calendar', [EventController::class, 'index']);
Route::get('/full-calendar-events', [EventController::class, 'getEvents']);
Route::post('/full-calendar-ajax', [EventController::class, 'ajax']);



require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
