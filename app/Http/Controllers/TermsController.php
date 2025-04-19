<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermsController extends Controller
{
    public function show()
    {
        return view('terms');
    }

    public function accept(Request $request)
    {
        $user = Auth::user();
        $user->accepted_terms = true;
        $user->save();

        if ($user->role === 'patient') {
            return redirect()->route('patients.dashboard')->with('success', 'You have accepted the Terms and Conditions.');
        } elseif ($user->role === 'therapist') {
            return redirect()->route('therapist.progress')->with('success', 'You have accepted the Terms and Conditions.');
        } else {
            return redirect()->route('home')->with('success', 'You have accepted the Terms and Conditions.');
        }
    }
}
