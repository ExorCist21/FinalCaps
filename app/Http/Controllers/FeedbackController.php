<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create($appointmentID)
    {
        // Resolve the appointment using the ID
        $appointment = Appointment::findOrFail($appointmentID);

        // Check if the patient has already left feedback
        $existingFeedback = Feedback::where('appointment_id', $appointment->id)
            ->where('patient_id', auth()->id())
            ->first();

        if ($existingFeedback) {
            return redirect()->route('patients.dashboard')->with('error', 'You have already left feedback for this appointment.');
        }

        return view('patients.feedback', compact('appointment'));
    }

    public function store(Request $request, $appointmentID)
    {
        $request->validate([
            'feedback' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
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
            'feedback' => $request->feedback,
            'rating' => $request->rating,
        ]);

        return redirect()->route('patient.session')->with('success', 'Thank you for your feedback!');
    }
}
