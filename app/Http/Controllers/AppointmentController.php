<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Feedback;
use App\Models\Appointment;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'datetime' => 'required|date',
            'description' => 'required|string|max:255',
            'therapist_id' => 'required|exists:users,id',
        ]);

        // Find the therapist
        $therapist = User::findOrFail($request->therapist_id);

        // Check if the therapist has sessions left
        if ($therapist->session_left <= 0) {
            // If no sessions left for the therapist, return an error message
            return redirect()->back()->with('error', 'The therapist has no sessions left. Please purchase more sessions.');
        }

        // Create a new appointment
        $appointment = Appointment::create([
            'datetime' => $request->datetime,
            'description' => $request->description,
            'therapistID' => $request->therapist_id,
            'patientID' => Auth::id(), // Use the logged-in patient's ID
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 'pending',
            'session_meeting' => 'online',
        ]);

        // Get the logged-in patient
        $patient = Auth::user();

        // Check if the patient has sessions left
        if ($patient->session_left <= 0) {
            // If no sessions left, return an error message
            return redirect()->back()->with('error', 'You have no sessions left. Please purchase more sessions.');
        }

        // Reduce the patient's session_left by 1
        $patient->session_left = $patient->session_left - 1;
        $patient->save(); // Save the updated patient data

        // Send notification to the therapist
        $patientName = $patient->name; // Get the patient's name

        Notification::create([
            'n_userID' => $request->therapist_id,  // Notify the therapist
            'type' => 'appointment',  // Define type for the notification
            'data' => $patientName, // Patient's name in the notification
            'created_at' => now(),
        ]);

        // Redirect with success messages
        return redirect()->route('patients.appointment')->with('success', 'Appointment successfully booked!');
    }

    public function cancelApp($appointmentID)
    {
        // Fetch the appointment using the provided appointment ID
        $appointment = Appointment::where('appointmentID', $appointmentID)
            ->where('patientID', Auth::id()) // Ensure the patient is the owner of the appointment
            ->first();

        // Check if the appointment exists
        if (!$appointment) {
            return redirect()->route('patients.appointment')->with('error', 'Appointment not found or you do not have permission to cancel this appointment.');
        }

        // Delete the appointment
        $appointment->delete();

        // Redirect with a success message
        return redirect()->route('patients.appointment')->with('success', 'Appointment successfully canceled!');
    }

    public function index()
    {
        // Fetch the patient's upcoming appointments along with therapist data
        $upcomingAppointments = Appointment::where('therapistID', Auth::id())
            ->where('status', 'approved')
            ->where('isDone', false)
            ->with('patient','progress')
            ->get();

        $doneAppointments = Appointment::where('therapistID', Auth::id())
            ->where('status', 'approved')
            ->where('isDone', true)
            ->with('patient','progress')
            ->get();

        return view('therapist.therapist-index', compact('upcomingAppointments', 'doneAppointments'));
    }

    public function indexPatient()
    {
        // Fetch the patient's upcoming appointments along with therapist data
        $appointments = Appointment::where('patientID', Auth::id())
            ->where('status', 'approved')
            ->where('isDone', false)
            ->with('therapist')
            ->get();

        $doneAppointments = Appointment::with(['patient', 'therapist'])
            ->where('status', 'approved') // Filter for done appointments
            ->get();

        return view('patients.patient-index', compact('appointments','doneAppointments'));
    }

    /**
     * Show the form for setting the consultation schedule for a specific appointment.
     */
    public function viewSession($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
    
        // Ensure the therapist is the one managing the appointment
        if ($appointment->therapistID !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    
        // Fetch the patient's details
        $patient = User::findOrFail($appointment->patientID);
    
        return view('therapist.view-session', compact('appointment', 'patient'));
    }    

    public function storeSession(Request $request, $appointmentId)
    {
        $request->validate([
            'meeting_type' => 'required|in:online,in-person',
            'session_meeting' => 'required|string|max:255',
        ]);

        $appointment = Appointment::findOrFail($appointmentId);

        // Ensure the therapist is the one managing the appointment
        if ($appointment->therapistID !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Update the appointment with the meeting type and details
        $appointment->update([
            'meeting_type' => $request->meeting_type,
            'session_meeting' => $request->session_meeting,
        ]);

        return redirect()->route('therapist.session')->with('success', 'Consultation details updated successfully!');
    }

    public function addInfo($appointmentId)
    {
        // Fetch the appointment using the provided appointmentId
        $appointment = Appointment::findOrFail($appointmentId);
        
        // Here you can load any other data or perform logic as needed
        
        // Return a view where the therapist can add the info for the appointment
        return view('therapist.add-info', compact('appointment'));
    }
    
    public function storeProgress(Request $request, $appointmentID)
    {
        // Validate the input
        $validatedData = $request->validate([
            'mental_condition' => 'required|string|max:255',
            'mood' => 'required|string|max:255',
            'symptoms' => 'required|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
            'risk' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentID);

        // Create new progress record
        $progress = new Progress();
        $progress->appointment_id = $appointment->appointmentID;
        $progress->mental_condition = $validatedData['mental_condition'];
        $progress->mood = $validatedData['mood'];
        $progress->symptoms = $validatedData['symptoms'];
        $progress->remarks = $validatedData['remarks'];
        $progress->risk = $validatedData['risk'];
        $progress->status = $validatedData['status'];
        $progress->save();

        $appointment->isDone = true;
        $appointment->save();

        // Redirect back to the appointment page or a confirmation page
        return redirect()->route('therapist.session')->with('success', 'Progress added successfully.');
    }

    public function viewProgress()
    {
        // Fetch all appointments for the authenticated therapist along with their related progress and patient
        $appointments = Appointment::with(['progress' => function ($query) {
            $query->latest('created_at'); // Get the most recent progress
        }, 'patient'])
        ->where('isDone', true)
        ->where('therapistID', auth()->id())
        ->get();

        // Return the appointments and their progress to the view
        return view('therapist.viewProgress', compact('appointments'));
    }

    public function storeProgressTherapist(Request $request, $appointmentID)
    {
        // Validate the input
        $request->validate([
            'mental_condition' => 'required|string|max:255',
            'mood' => 'required|string|max:255',
            'symptoms' => 'required|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
            'risk' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentID);

        // Create new progress record
        $progress = new Progress();
        $progress->appointment_id = $appointment->appointmentID;
        $progress->mental_condition = $request->mental_condition;
        $progress->mood = $request->mood;
        $progress->symptoms = $request->symptoms;
        $progress->remarks = $request->remarks;
        $progress->risk = $request->risk;
        $progress->status = $request->status;
        $progress->save();

        // Redirect back to the appointment page or a confirmation page
        return redirect()->route('therapist.progress')->with('success', 'Progress added successfully.');
    }

    public function showPatientAppointments()
    {
        // Fetch appointments with progress and therapist details for the patient
        $appointments = Appointment::with(['progress', 'therapist'])
            ->where('patientID', auth()->user()->id) // Assuming authenticated patient
            ->where('status','approved')
            ->where('isDone', true)
            ->orderBy('datetime', 'asc')
            ->get();

        // Return the view with the appointments
        return view('patients.card-progress', compact('appointments'));
    }

    // Show progress for a specific appointment
    public function showProgress($appointmentID)
    {
        // Fetch the specific appointment with its progress
        $appointment = Appointment::with('progress')->findOrFail($appointmentID);

        // Return the progress view for this specific appointment
        return view('patients.progress', compact('appointment'));
    }

}
