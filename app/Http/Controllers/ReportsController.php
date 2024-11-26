<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function adminIndex()
    {
        // Overall metrics for admin
        $totalAppointments = Appointment::count();
        $completedAppointments = Appointment::where('isDone', true)->count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();

        $totalRevenue = Payment::where('status', 'Confirmed')->sum('amount');
        $pendingPayments = Payment::where('status', 'Pending')->count();

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
            'topTherapists'
        ));
    }

    // Therapist Reports
    public function therapistIndex()
    {
        $therapistID = Auth::user()->id; // Assuming therapists are authenticated users

        $appointments = Appointment::where('therapistID', $therapistID)->count();
        $completedAppointments = Appointment::where('therapistID', $therapistID)->where('isDone', true)->count();

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
            'patientProgress'
        ));
    }
}
