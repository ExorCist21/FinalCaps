<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Progress;
use App\Models\User;
use App\Models\Feedback;
use App\Models\SystemFeedbacks;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function adminIndex()
    {
        // Overall metrics for admin
        $totalAppointments = Appointment::count();
        $completedAppointments = Appointment::where('isDone', true)->count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();

        // Get the admin user and their total_revenue
        $admin = User::where('role', 'admin')->first();
        
        // If the admin is not found, set totalRevenue to 0 (or handle as needed)
        $totalRevenue = $admin ? $admin->total_revenue : 0;

        $pendingPayments = Payment::where('status', 'Pending')->count();

        $feedbacks = Feedback::count();
        $systemfeedbacks = SystemFeedbacks::count();

        $activeSubscriptions = Subscription::where('status', 'Active')->count();
        $inactiveSubscriptions = Subscription::where('status', 'Inactive')->count();

        $topTherapists = Appointment::select('therapistID', \DB::raw('COUNT(*) as total'))
            ->groupBy('therapistID')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.reports', compact(
            'totalAppointments',
            'completedAppointments',
            'pendingAppointments',
            'totalRevenue',
            'pendingPayments',
            'activeSubscriptions',
            'inactiveSubscriptions',
            'topTherapists',
            'feedbacks',
            'systemfeedbacks'
        ));
    }


    // Therapist Reports
    public function therapistIndex()
    {
        $therapistID = Auth::user()->id; 
        
        $therapist = Auth::user();

        $totalRevenue = $therapist ? $therapist->total_revenue : 0;

        $appointments = Appointment::where('therapistID', $therapistID)->count();
        $completedAppointments = Appointment::where('therapistID', $therapistID)->where('isDone', true)->whereHas('progress', function ($query) {
            $query->where('status', 'Completed'); // Ensure status is 'Completed'
        })->count();

        $patientProgress = Progress::whereIn(
            'appointment_id',
            Appointment::where('therapistID', $therapistID)
                ->pluck('appointmentID') 
        )->where('status', 'Completed') 
          ->orderBy('created_at', 'desc') 
          ->get();

        return view('therapist.reports', compact(
            'appointments',
            'completedAppointments',
            'patientProgress',
            'totalRevenue'
        ));
    }
}
