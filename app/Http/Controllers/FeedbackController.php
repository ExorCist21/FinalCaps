<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use App\Models\Appointment;
use App\Models\SystemFeedbacks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create($appointmentID)
    {
        // Resolve the appointment using the ID
        $appointment = Appointment::with('therapist')->findOrFail($appointmentID);
    
        // Check if the patient has already left feedback
        $existingFeedback = Feedback::where('appointment_id', $appointment->id)
            ->where('patient_id', auth()->id())
            ->first();
    
        if ($existingFeedback) {
            return redirect()->route('patients.dashboard')->with('error', 'You have already left feedback for this appointment.');
        }
    
        // Pass the appointment and therapist information to the view
        return view('patients.feedback', compact('appointment'));
    }    

    public function store(Request $request, $appointmentID)
    {
        $request->validate([
            'therapist_feedback' => 'required|string',
            'therapist_rating' => 'required|integer|between:1,5',
            'system_feedback' => 'required|string',
            'system_rating' => 'required|integer|between:1,5',
        ]);

        $appointment = Appointment::with('therapist')->findOrFail($appointmentID);

        $existingFeedback = Feedback::where('appointment_id', $appointmentID)
        ->where('patient_id', auth()->id())
        ->first();

        if ($existingFeedback) {
            return redirect()->route('patient.session')
                ->with('error', 'You have already left feedback for this appointment.');
        }

        Feedback::create([
            'appointment_id' => $appointmentID,
            'patient_id' => auth()->id(),
            'therapist_id' => $appointment->therapistID,
            'feedback' => $request->therapist_feedback,
            'rating' => $request->therapist_rating,
        ]);


        SystemFeedbacks::create([
            'userID' => auth()->id(),
            'system_feedback' => $request->system_feedback,
            'system_rating' => $request->system_rating,
        ]);

        return redirect()->route('patient.session')->with('success', 'Thank you for your feedback!');
    }

    public function showFeedbackForm()
    {
        return view('feedback.form');
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5'
        ]);

        SystemFeedbacks::create([
            'userID' => Auth::id(),
            'system_feedback' => $request->message,
            'system_rating' => $request->rating,
        ]);

        return redirect()->route('therapist.progress')->with('success', 'Thank you for your feedback!');
    }
}
