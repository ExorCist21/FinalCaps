<?php


namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use App\Models\Appointment;
use App\Models\TherapistInformation;
use Illuminate\Support\Facades\Auth;

class TherapistController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user by their ID
        $therapists = User::where('role', 'therapist')
                        ->where('id', auth()->id()) // Filter by authenticated user's ID
                        ->get();

        // Fetch all the contents posted by the admin
        $contents = Content::all(); // You can modify this query if needed, e.g., based on content type or visibility

        return view('patients.dashboard', compact('therapists', 'contents'));
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

        // Check if already approved
        if ($appointment->status === 'approved') {
            return redirect()->back()->with('info', 'This appointment is already approved.');
        }

        // Find the patient
        $patient = User::findOrFail($appointment->patientID);

        $patient->save();

        // Update appointment status
        $appointment->update([
            'status' => 'approved',
            'updated_at' => now(),
        ]);
        $this->notifyPatient($appointment, 'appointment_approved');
        return redirect()->back()->with('success', 'Appointment approved successfully. Session deducted.');
    }

    public function disapproveApp($appointmentID) {
        $appointment = Appointment::findOrFail($appointmentID);
        $appointment->status = 'disapproved'; // Set the status to disapproved
        $appointment->save();
        $this->notifyPatient($appointment, 'appointment_disapproved');
        return redirect()->back()->with('success', 'Appointment disapproved successfully.');
    }
    protected function notifyPatient(Appointment $appointment, $type)
    {
        // Find the patient based on the patientID from the appointment
        $patient = User::find($appointment->patientID);  // Assuming patientID is the user ID
        $therapist = User::find($appointment->therapistID);
        // Check if the patient exists
        if ($patient) {
            // Create the notification for the patient
            Notification::create([
                'n_userID' => $patient->id,  
                'data' =>  $therapist->first_name,  
                'type' => $type,  
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

    public function editProfile()
    {
        // Get the current therapist information
        $therapistInformation = auth()->user()->therapistInformation;
        
        return view('therapist.profile', compact('therapistInformation'));
    }

    public function confirmPayment(Request $request, $appointmentID)
    {
        $appointment = Appointment::findOrFail($appointmentID);

        // Ensure that the payment exists and is in 'pending' status
        $payment = $appointment->payments->firstWhere('status', 'Pending'); // Get the first payment with 'pending' status

        if ($payment) {
            // Update the payment status to 'Confirmed'
            $payment->status = 'Confirmed';
            $payment->save(); // Save the changes

            $therapist = $appointment->therapist;
            $therapist->total_revenue += $payment->amount;
            $therapist->save();
        }

        return redirect()->route('therapist.progress')->with('success', 'Payment confirmed successfully.');
    }

    public function addGcashNumber(Request $request)
    {
        // Validate the GCash number
        $validated = $request->validate([
            'gcash_number' => 'required|string|max:15',
            'appointment_id' => 'required|exists:appointments,appointmentID',
        ]);

        // Find the therapist's information and update the GCash number
        $therapistInformation = TherapistInformation::where('user_id', auth()->id())->first();
        
        if ($therapistInformation) {
            $therapistInformation->gcash_number = $validated['gcash_number'];
            $therapistInformation->save();

            return back()->with('success', 'GCash number added successfully.');
        }

        return back()->with('error', 'Unable to update GCash number. Please try again.');
}


    public function updateProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'clinic_name' => 'nullable|string|max:255',
            'awards' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
        ]);

        $therapistInformation = auth()->user()->therapistInformation()->firstOrCreate([
            'user_id' => auth()->id(), 
        ]);

        // Update the profile information
        $therapistInformation->update($validated);

        // Redirect with success message
        return redirect()->route('therapist.background')
                         ->with('success', 'Your profile has been updated successfully.');
    }

    public function showBackground()
    {
        // Get the current therapist's information
        $therapistInformation = auth()->user()->therapistInformation;

        return view('therapist.background', compact('therapistInformation'));
    }

}
