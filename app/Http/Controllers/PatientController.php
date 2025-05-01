<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Content;
use App\Models\Feedback;
use App\Models\Appointment;
use App\Models\TherapistInformation;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated patient
        $patients = User::where('role', 'patient')
                        ->where('id', auth()->id())
                        ->get();

        // Initialize the query for filtering content
        $query = Content::query();

        // Apply category filter if selected
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Fetch filtered content with creator relationship
        $contents = $query->with('creator')->get();

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


    public function appIndex(Request $request)
    {
        // Base query to get therapists with their related information
        $query = User::where('role', 'therapist')->with('therapistInformation', 'feedback');

        // Apply expertise filter if selected
        if ($request->has('occupation') && $request->occupation != '') {
            $query->whereHas('therapistInformation', function ($q) use ($request) {
                $q->where('occupation', $request->occupation);
            });
        }

        if ($request->filled('expertise')) {
            $query->whereHas('therapistInformation', function ($q) use ($request) {
                $q->where('expertise', $request->expertise);
            });
        }

        // Get the filtered or all therapists
        $therapists = $query->get();

        $expertiseOptions = \App\Models\TherapistInformation::select('expertise')
        ->whereNotNull('expertise')
        ->distinct()
        ->pluck('expertise');

        $occuOptions = \App\Models\TherapistInformation::select('occupation')
        ->whereNotNull('occupation')
        ->distinct()
        ->pluck('occupation');

        // Pass the therapists and expertise filter value to the view
        return view('patients.bookappointments', compact('therapists','expertiseOptions','occuOptions'));
    }


    public function appDetails($id)
    {
        // Fetch the therapist by ID
        $therapist = User::findOrFail($id);

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
