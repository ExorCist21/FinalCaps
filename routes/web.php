<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Chat\Index;

// Default Routes (e.g., for login/registration)
Route::get('/', function () {
    return view('welcome');
})->middleware(['guest', 'prevent.back.history']);

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'therapist') {
        return redirect()->route('therapist.dashboard');
    } elseif ($user->role === 'patient') {
        return redirect()->route('patients.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes (after login)
Route::middleware('auth')->group(function () {
    // Grouped by Role

    // **Patient Routes** - All routes for patients
    Route::prefix('patient')->middleware('role:patient', 'verified')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'index'])->name('patients.dashboard');
        Route::get('/appointment', [PatientController::class, 'viewApp'])->name('patients.appointment');
        Route::get('/bookappointment', [PatientController::class, 'appIndex'])->name('patients.bookappointments');
        Route::get('/bookappointment/{id}', [PatientController::class, 'appDetails'])->name('patients.therapist-details');
        Route::post('/bookappointment/store', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::post('/appointment/{appointmentID}', [AppointmentController::class, 'cancelApp'])->name('patients.cancelApp');
        Route::get('/progress', [AppointmentController::class, 'showPatientAppointments'])->name('patient.progress');
        Route::get('/progress/{appointmentID}', [AppointmentController::class, 'showProgress'])->name('patient.show.progress');
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/with/{therapist}/{appointment}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/send/{conversation}', [ChatController::class, 'sendMessage'])->name('chat.send');
        Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.all');
        Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications'])->name('notifications.unread');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::get('/session', [AppointmentController::class, 'indexPatient'])->name('patient.session');
        Route::get('/session/{appointmentId}/feedback', [FeedbackController::class, 'create'])->name('appointments.feedback.create');
        Route::post('/session/{appointmentId}/feedback', [FeedbackController::class, 'store'])->name('appointments.feedback.store');
    });

    // **Therapist Routes** - All routes for therapists
    Route::prefix('therapist')->middleware('role:therapist', 'verified')->group(function () {
        Route::get('/dashboard', [TherapistController::class, 'index'])->name('therapist.dashboard');
        Route::get('/appointment', [TherapistController::class, 'appIndex'])->name('therapist.appointment');
        Route::post('/appointment/{appointmentID}/approve', [TherapistController::class, 'approveApp'])->name('therapist.approve');
        Route::post('/appointment/{appointmentID}/disapprove', [TherapistController::class, 'disapproveApp'])->name('therapist.disapprove');
        Route::get('/session', [AppointmentController::class, 'index'])->name('therapist.session');
        Route::get('/session/{appointmentId}/schedule', [AppointmentController::class, 'viewSession'])->name('therapist.viewSession');
        Route::post('/session/{appointmentId}/schedule', [AppointmentController::class, 'storeSession'])->name('therapist.storeSession');
        Route::put('/session/{appointmentId}/mark-as-done', [TherapistController::class, 'markAsDone'])->name('therapist.markAsDone');
        Route::get('/profile', [TherapistController::class, 'editProfile'])->name('therapist.profile');
        Route::put('/profile', [TherapistController::class, 'updateProfile'])->name('therapist.updateProfile');
        Route::get('/chat', [ChatController::class, 'therapistIndex'])->name('therapist.chats');
        Route::get('/progress', [AppointmentController::class, 'viewProgress'])->name('therapist.progress');
        Route::get('/background', [TherapistController::class, 'showBackground'])->name('therapist.background');
    });

    // **Admin Routes** - All routes for admin
    Route::prefix('admin')->middleware('role:admin', 'verified')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/therapists', [AdminController::class, 'therapists'])->name('admin.therapists');
        Route::get('/patients', [AdminController::class, 'patients'])->name('admin.patients');
        Route::post('/patients/{id}/deactivate', [PatientController::class, 'deactivate'])->name('patients.deactivate');
        Route::post('/therapist/{id}/deactivate', [TherapistController::class, 'deactivate'])->name('therapist.deactivate');
        Route::post('/patients/{id}/activate', [PatientController::class, 'activate'])->name('patients.activate');
        Route::post('/therapist/{id}/activate', [TherapistController::class, 'activate'])->name('therapist.activate');
    });
});

// Profile Management Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ensure routes are only accessible by authenticated users with the `verified` email
Route::middleware('auth')->group(function () {
    // Default fallback for non-verified users
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });
});




Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'auth'])
    ->name('verification.verify');
Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware(['auth'])->name('verification.notice');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Additional routes
require __DIR__.'/auth.php';
