<?php


namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class TherapistController extends Controller
{
    public function index()
    {
        $therapists = User::where('role', 'therapist')
        ->where('id', auth()->id())->get();
        return view('therapist.dashboard', compact('therapists'));
    }

    public function appIndex()
    {
        // Fetch the appointments where the logged-in therapist is assigned
        $appointments = Appointment::where('therapistID', Auth::id())->with('patient')->get();

        // Pass appointments to the view
        return view('therapist.appointments', compact('appointments'));
    }

    public function showRegistrationForm() {
        return view('therapist.register');
    }
    
    public function approveApp($appointmentID) {
        $appointment = Appointment::findOrFail($appointmentID);
        $appointment->status = 'approved'; // Set the status to approved
        $appointment->save();
        $this->notifyPatientApprove($appointment);
        return redirect()->back()->with('success', 'Appointment approved successfully.');
    }

    public function disapproveApp($appointmentID) {
        $appointment = Appointment::findOrFail($appointmentID);
        $appointment->status = 'disapproved'; // Set the status to disapproved
        $appointment->save();
    
        return redirect()->back()->with('success', 'Appointment disapproved successfully.');
    }
    protected function notifyPatientApprove(Appointment $appointment)
{
    // Find the patient based on the patientID from the appointment
    $patient = User::find($appointment->patientID);  // Assuming patientID is the user ID
    $therapist = User::find($appointment->therapistID);
    // Check if the patient exists
    if ($patient) {
        // Create the notification for the patient
        Notification::create([
            'n_userID' => $patient->id,  // Use $patient->id, not $patient->patientID
            'data' =>  $therapist->name,  // Store the patient's name in the notification's data field
            'type' => 'appointment_approved',  // Notification type
        ]);
    }
}


    public function deactivate($id)
    {
        $therapist = User::findOrFail($id);
        $therapist->isActive = 0; // Set status to deactivated
        $therapist->save();

        return redirect()->back()->with('success', 'Therapist has been deactivated successfully.');
    }

    public function activate($id)
    {
        $therapist = User::findOrFail($id);
        $therapist->isActive = 1; // Set status to activated
        $therapist->save();

        return redirect()->back()->with('success', 'Therapist has been activated successfully.');
    }

    public function markAsDone($appointmentId)
    {
        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentId);

        // Update the isDone field
        $appointment->isDone = true;
        $appointment->save();

        return redirect()->route('therapist.session')->with('success', 'Appointment marked as done.');
    }

}
