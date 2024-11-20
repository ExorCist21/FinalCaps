<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Appointment;
use App\Models\Progress;
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

        // Create a new appointment
        $patient = Appointment::create([
            'datetime' => $request->datetime,
            'description' => $request->description,
            'therapistID' => $request->therapist_id,
            'patientID' => Auth::id(), // therapist's ID
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 'pending',
            'session_meeting' => 'online',
        ]);

        $patientName = Auth::user()->name;

        Notification::create([
            'n_userID' => $request->therapist_id,  // Notify the therapist
            'type' => 'appointment',  // You can define this type for negotiation
            'data' => $patientName, // Custom message
            'created_at' => now(),
        ]);
        // Redirect with success message
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
            ->with('therapist')
            ->get();

        return view('patients.patient-index', compact('appointments'));
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

        return view('therapist.view-session', compact('appointment'));
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
        return redirect()->route('therapist.session')->with('success', 'Progress added successfully.');
    }

    public function viewProgress()
    {
        // Fetch all appointments for the authenticated therapist along with their related progress and patient
        $appointments = Appointment::with('progress', 'patient')
            ->where('isDone', true)
            ->where('therapistID', auth()->id()) // Only fetch appointments for the authenticated therapist
            ->get();

        // Return the appointments and their progress to the view
        return view('therapist.viewProgress', compact('appointments'));
    }

    public function updateProgress(Request $request, $appointmentID)
    {
        // Validate request data
        $request->validate([
            'mental_condition' => 'required|string',
            'mood' => 'required|string',
            'symptoms' => 'required|string',
            'remarks' => 'nullable|string',
            'risk' => 'required|string',
            'status' => 'required|string',
        ]);

        // Find the progress record linked to the appointmentID
        $progress = Progress::where('appointment_id', $appointmentID)->first();

        if (!$progress) {
            return redirect()
                ->route('appointment.progress', ['appointmentID' => $appointmentID])
                ->with('error', 'Progress not found for the specified appointment.');
        }

        // Update progress data
        $progress->update([
            'mental_condition' => $request->input('mental_condition'),
            'mood' => $request->input('mood'),
            'symptoms' => $request->input('symptoms'),
            'remarks' => $request->input('remarks'),
            'risk' => $request->input('risk'),
            'status' => $request->input('status'),
        ]);

        return redirect()
            ->route('therapist.progress', ['appointmentID' => $appointmentID])
            ->with('success', 'Progress updated successfully!');
    }



    public function showProgress($appointmentID)
    {
        // Fetch the appointment along with its progress and related data
        $appointment = Appointment::with(['progress', 'patient', 'therapist'])
            ->findOrFail($appointmentID);

        return view('therapist.progress-detail', compact('appointment'));
    }

}
