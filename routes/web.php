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
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Chat\Index;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\InvoiceController;


// Default Routes (e.g., for login/registration)
Route::get('/', function () {
    return view('welcome');
})->middleware(['guest', 'prevent.back.history']);

// Registration routes
Route::get('/select-register', [AdminController::class, 'selectRegister'])->name('view.select-register')->middleware(['guest', 'prevent.back.history']);
Route::get('/register/patient', [PatientController::class, 'showRegistrationForm'])->name('patient.register')->middleware(['guest', 'prevent.back.history']);
Route::get('/register/therapist', [TherapistController::class, 'showRegistrationForm'])->name('therapist.register')->middleware(['guest', 'prevent.back.history']);
Route::post('/register/patient', [RegisteredUserController::class, 'storePatient'])->name('patient.store');
Route::post('/register/therapist', [RegisteredUserController::class, 'storeTherapist'])->name('therapist.store');

// Determine what users role is gonna log in
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'therapist') {
        return redirect()->route('therapist.progress');
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


    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    // Grouped by Role

    // *Patient Routes* - All routes for patients
    Route::prefix('patient')->middleware('role:patient', 'verified', 'prevent.back.history')->group(function () {
        Route::get('/patient/session', [AppointmentController::class, 'indexPatient'])->name('patient.session');
        Route::get('/patient/session/{appointmentId}/schedule', [AppointmentController::class, 'viewPatient'])->name('patient.viewSession');
        Route::get('/dashboard', [PatientController::class, 'index'])->name('patients.dashboard');
        Route::get('/appointment', [PatientController::class, 'viewApp'])->name('patients.appointment');
        Route::get('/bookappointment', [PatientController::class, 'appIndex'])->name('patients.bookappointments');
        Route::get('/bookappointment/{id}', [PatientController::class, 'appDetails'])->name('patients.therapist-details');
        Route::post('/bookappointment/store', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::post('/appointment/{appointmentID}', [AppointmentController::class, 'cancelApp'])->name('patients.cancelApp');
        Route::get('/progress', [AppointmentController::class, 'showPatientAppointments'])->name('patient.progress');
        Route::get('/progress/{appointmentID}', [AppointmentController::class, 'showProgress'])->name('patient.show.progress');
        Route::get('/history', [AppointmentController::class, 'indexPatient'])->name('patient.session');
        Route::get('/history/{appointmentId}/feedback', [FeedbackController::class, 'create'])->name('appointments.feedback.create');
        Route::post('/history/{appointmentId}/feedback', [FeedbackController::class, 'store'])->name('appointments.feedback.store');
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/plans', [SubscriptionController::class, 'subPlan'])->name('subscriptions.plan');
        Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
        Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
        Route::get('/subscriptions/payment/proceed', [SubscriptionController::class, 'payment'])->name('subscriptions.payment');
        Route::post('/subscriptions/payment', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/subscriptions/{id}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
        Route::post('/subscriptions/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
        Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
        Route::get('/chat', [ChatbotController::class, 'chat'])->name('chatbot.index');
        Route::post('/send-message', [ChatbotController::class, 'sendMessage'])->name('send.message');
        Route::get('/invoice/{invoice}', [InvoiceController::class, 'download'])->name('patient.downloadInvoice');
    });

    // Therapist Routes - All routes for therapists
    Route::prefix('therapist')->middleware('role:therapist', 'verified', 'check.isActive')->group(function () {
        Route::get('/appointment', [TherapistController::class, 'appIndex'])->name('therapist.appointment');
        Route::post('/appointment/{appointmentID}/approve', [TherapistController::class, 'approveApp'])->name('therapist.approve');
        Route::put('/appointment/{appointmentID}/confirm-payment', [TherapistController::class, 'confirmPayment'])->name('therapist.payment.confirm');
        Route::post('/appointment/{appointmentID}/disapprove', [TherapistController::class, 'disapproveApp'])->name('therapist.disapprove');
        Route::get('/session', [AppointmentController::class, 'index'])->name('therapist.session');
        Route::get('/session/{appointmentId}/schedule', [AppointmentController::class, 'viewSession'])->name('therapist.viewSession');
        Route::post('/session/{appointmentId}/schedule', [AppointmentController::class, 'storeSession'])->name('therapist.storeSession');
        Route::put('/session/{appointmentId}/mark-as-done', [TherapistController::class, 'markAsDone'])->name('therapist.markAsDone');
        Route::post('/session/{appointmentID}/progress', [AppointmentController::class, 'storeProgress'])->name('therapist.storeProgress');
        Route::get('/profile', [TherapistController::class, 'editProfile'])->name('profile.therapist');
        Route::put('/profile', [TherapistController::class, 'updateProfile'])->name('therapist.updateProfile');
        Route::get('/chat', [ChatController::class, 'therapistIndex'])->name('therapist.chats');
        Route::get('/progress', [AppointmentController::class, 'viewProgress'])->name('therapist.progress');
        Route::post('/progress/add-gcash', [TherapistController::class, 'addGcashNumber'])->name('therapist.addGcashNumber');
        Route::get('/progress/{appointmentID}', [AppointmentController::class, 'showProgress'])->name('therapist.show.progress');
        Route::put('/appointments/{appointmentID}/update-progress', [AppointmentController::class, 'storeProgressTherapist'])->name('therapist.appointment.updateProgress');
        Route::get('/background', [TherapistController::class, 'showBackground'])->name('therapist.background');
        Route::get('/reports', [ReportsController::class, 'therapistIndex'])->name('therapist.reports.index');
        Route::get('/feedback', [FeedbackController::class, 'showFeedbackForm'])->name('feedback.form');
        Route::post('/feedback/submit', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
    });

    // *Admin Routes* - All routes for admin
    Route::prefix('admin')->middleware('role:admin', 'verified')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/therapists', [AdminController::class, 'therapists'])->name('admin.therapists');
        Route::get('/patients', [AdminController::class, 'patients'])->name('admin.patients');
        Route::get('/content', [ContentController::class, 'index'])->name('admin.contentmng');
        Route::post('/content', [ContentController::class, 'store'])->name('admin.contentmng.store');
        Route::delete('/content/{content_id}', [ContentController::class, 'destroy'])->name('admin.contentmng.delete');
        Route::get('/content/{content_id}/edit', [ContentController::class, 'edit'])->name('admin.contentmng.edit');
        Route::put('/content/{content_id}/edit', [ContentController::class, 'update'])->name('admin.contentmng.update');
        Route::post('/content', [ContentController::class, 'store'])->name('admin.contentmng.store');
        Route::get('/subscription', [SubscriptionController::class, 'pendingPayments'])->name('admin.subscribe');
        Route::post('/subscription/{subscriptionId}/approve', [SubscriptionController::class, 'approvePayment'])->name('admin.subscriptions.approve');
        Route::post('/admin/subscriptions/{id}/approve', [AdminController::class, 'approvePayment'])->name('admin.subscriptions.approve');
        Route::post('/patients/{id}/deactivate', [PatientController::class, 'deactivate'])->name('patients.deactivate');
        Route::post('/therapist/{id}/deactivate', [TherapistController::class, 'deactivate'])->name('therapist.deactivate');
        Route::post('/patients/{id}/activate', [PatientController::class, 'activate'])->name('patients.activate');
        Route::post('/therapist/{id}/activate', [TherapistController::class, 'activate'])->name('therapist.activate');
        Route::get('/send-payment', [AdminController::class, 'showAppointments'])->name('admin.appointments');
        Route::get('/send-payment/{appointmentID}', [AdminController::class, 'showPaymentForm'])->name('admin.showPaymentForm');
        Route::post('/send-payment/{appointmentID}', [AdminController::class, 'sendPayment'])->name('admin.sendPayment');
        Route::get('/reports', [ReportsController::class, 'adminIndex'])->name('admin.reports.index');
        Route::get('/reports/feedbacks', [AdminController::class, 'viewFeedbacks'])->name('admin.reports.feedbacks');
        Route::get('/reports/therapist-feedbacks', [AdminController::class, 'therapistFeedbacks'])->name('admin.therapistFeedbacks');
        Route::get('/reports/system-feedbacks', [AdminController::class, 'systemFeedbacks'])->name('admin.systemFeedbacks');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat/conversation-list', [ChatController::class, 'fetchConversationList']);
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index'); // Added name here
    Route::get('/chat/load-initial-messages', [ChatController::class, 'loadInitialMessages']);
    Route::get('/chat/fetch-unread-messages', [ChatController::class, 'fetchUnreadMessages']);
    Route::post('/chat/send-message', [ChatController::class, 'sendMessage']); 
});

// Ensure routes are only accessible by authenticated users with the verified email
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

Route::get('/inactive', function () {
    return view('inactive');
})->name('inactive.user.page');

// Additional routes
require __DIR__.'/auth.php';
