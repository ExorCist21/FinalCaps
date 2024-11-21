<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function reports()
    {
        return view('admin.reports');
    }
    
    public function therapists()
    {
        $therapists = User::where('role', 'therapist')
        ->with('therapistInformation')->get();
        
        // Assuming 'role' column holds user roles
        return view('admin.therapist', compact('therapists'));
    }

    public function patients()
    {
        $patients = User::where('role', 'patient')->get(); // Assuming 'role' column holds user roles
        return view('admin.patient', compact('patients'));
    }

    public function selectRegister() {
        return view ('select-register');
    }
}
