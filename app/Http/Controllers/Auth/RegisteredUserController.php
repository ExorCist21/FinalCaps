<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:patient,therapist,admin'], // restrict role input
        ]);

        // Create the user with the requested role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Store the role in the database
        ]);

        event(new Registered($user));

        // After registration, redirect to the email verification page
        return redirect()->route('verification.notice');
    }

    /**
     * Handle an incoming registration request for patients.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storePatient(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user with the patient role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        event(new Registered($user));

        // Log the user in after registration
        Auth::login($user);

        // Redirect to the email verification page if not verified
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Redirect based on role if email is verified
        return redirect()->route('patients.dashboard');
    }

    /**
     * Handle an incoming registration request for therapists.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeTherapist(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user with the therapist role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'therapist',
        ]);

        event(new Registered($user));

        // Log the user in after registration
        Auth::login($user);

        // Redirect to the email verification page if not verified
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Redirect based on role if email is verified
        return redirect()->route('therapist.dashboard');
    }
}
