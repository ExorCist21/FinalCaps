<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Content;
use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user by their ID
        $patients = User::where('role', 'patient')
                        ->where('id', auth()->id()) // Filter by authenticated user's ID
                        ->get();

        // Fetch all the contents posted by the admin
        $contents = Content::all(); // You can modify this query if needed, e.g., based on content type or visibility

        return view('patients.dashboard', compact('patients', 'contents'));
    }



    public function viewApp()
    {
        // Get the currently authenticated patient
        $patient = Auth::user();

        // Fetch appointments for the authenticated patient
        $appointments = Appointment::where('patientID', $patient->id)->get();

        // Pass appointments to the view
        return view('patients.viewappointments', compact('appointments'));
    }


    public function appIndex() {
        $therapists = User::where('role', 'therapist')
        ->with('therapistInformation','feedback')->get();
        
        // Pass therapists to the view
        return view('patients.bookappointments', compact('therapists'));
    }

    public function appDetails($id)
    {
        // Fetch the therapist by ID
        $therapist = User::findOrFail($id);

        // Pass the therapist to the view
        return view('patients.therapist-details', compact('therapist'));
    }

    public function showRegistrationForm()
    {
        return view('patients.register');
    }

    public function deactivate($id)
    {
        $patient = User::findOrFail($id);
        $patient->isActive = 0; // Set status to deactivated
        $patient->save();

        return redirect()->back()->with('success', 'Patient has been deactivated successfully.');
    }

    public function activate($id)
    {
        $patient = User::findOrFail($id);
        $patient->isActive = 1; // Set status to activated
        $patient->save();

        return redirect()->back()->with('success', 'Patient has been activated successfully.');
    }
}
