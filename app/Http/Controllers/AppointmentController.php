<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Feedback;
use App\Models\Appointment;
use App\Models\Progress;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'datetime' => 'required|date',
            'description' => 'required|string|max:255',
            'risk_level' => 'required|string|in:Low,Moderate,High,Critical',
            'therapist_id' => 'required|exists:users,id',
        ]);

        // Convert datetime input to Carbon instance
        $appointmentTime = Carbon::parse($request->datetime);
        $startOfHour = $appointmentTime->copy()->startOfHour(); // Start of hour (e.g., 4:00 PM)
        $endOfHour = $appointmentTime->copy()->endOfHour(); // End of hour (e.g., 4:59 PM)

        // Check for existing appointments in the same 1-hour range
        $conflictingAppointment = Appointment::where('therapistID', $request->therapist_id)
            ->whereBetween('datetime', [$startOfHour, $endOfHour]) // Check conflicts in the same hour
            ->whereIn('status', ['pending', 'approved']) // Ignore cancelled/disapproved
            ->exists();

        if ($conflictingAppointment) {
            return redirect()->back()->withErrors(['error' => 'This time slot is already booked. Please choose a different hour.']);
        }

        // Create the appointment (pending)
        $appointment = Appointment::create([
            'datetime' => $request->datetime,
            'description' => $request->description,
            'risk_level' => $request->risk_level,
            'therapistID' => $request->therapist_id,
            'patientID' => Auth::id(),
            'status' => 'pending',
            'session_meeting' => 'online',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send notification to the therapist
        Notification::create([
            'n_userID' => $request->therapist_id,
            'type' => 'appointment',
            'data' => Auth::user()->name,
            'created_at' => now(),
        ]);

        return redirect()->route('patients.appointment')->with('success', 'Appointment successfully booked! The next available slot will be in the next hour.');
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
        $validatedData = $request->validate([
            'mental_condition' => 'required|string|max:255',
            'mood' => 'required|string|max:255',
            'symptoms' => 'required|string|max:1000',
            'remarks' => 'nullable|string|max:1000',
            'risk' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'medicine_name' => 'nullable|string|max:255',
            'medicine_duration' => 'nullable|string|max:255',
            'invoice_notes' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::findOrFail($appointmentID);
        $therapist = Auth::user();

        Progress::create([
            'appointment_id' => $appointment->appointmentID,
            'mental_condition' => $validatedData['mental_condition'],
            'mood' => $validatedData['mood'],
            'symptoms' => $validatedData['symptoms'],
            'remarks' => $validatedData['remarks'],
            'risk' => $validatedData['risk'],
            'status' => $validatedData['status'],
        ]);

        if ($therapist->therapistInformation->expertise === 'psychiatrist') {
            Invoice::create([
                'appointmentID' => $appointmentID,
                'therapist_id' => $therapist->id,
                'patient_id' => $appointment->patientID,
                'medicine_name' => $validatedData['medicine_name'],
                'medicine_duration' => $validatedData['medicine_duration'],
                'notes' => $validatedData['invoice_notes'],
            ]);
        }

        $appointment->isDone = 1; // Explicitly setting it as true (1)
        $appointment->save();

        return redirect()->route('therapist.session')->with('success', 'Progress added successfully.');
    }

    public function viewProgress()
    {
        // Fetch all appointments for the authenticated therapist along with their related progress and patient
        $appointments = Appointment::with(['progress' => function ($query) {
            $query->latest('created_at'); // Get the most recent progress
        }, 'patient','payments'])
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

    public function sendEmail($appointmentID)
    {
        $invoice = Invoice::where('appointmentID', $appointmentID)->firstOrFail();
        Mail::to($invoice->patient->email)->send(new InvoiceMail($invoice));

        return response()->json(['message' => 'Invoice sent successfully!']);
    }
}
