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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:patient,therapist,admin'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'session_left' => 0,
        ]);

        event(new Registered($user));
        Auth::login($user);

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('terms.show');
    }

    /**
     * Handle an incoming registration request for patients.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storePatient(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
            'session_left' => 0,
        ]);

        event(new Registered($user));
        Auth::login($user);

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('terms.show');
    }

    /**
     * Handle an incoming registration request for therapists.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeTherapist(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'expertise' => ['required', 'string', 'max:255'],
            'occupation' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:255'],
            'awards' => ['nullable', 'string', 'max:255'],
            'clinic_name' => ['nullable', 'string', 'max:255'],
            'image_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificates.*' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpeg,png', 'max:4096'],
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image_picture')) {
            $imagePath = $request->file('image_picture')->store('images', 'public');
        }

        $certificatePaths = [];
        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $certificate) {
                $certificatePaths[] = $certificate->store('certificates', 'public');
            }
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'therapist',
            'isActive' => 0,
            'session_left' => 0,
        ]);

        $user->therapistInformation()->create([
            'expertise' => $request->expertise,
            'occupation' => $request->occupation,
            'contact_number' => $request->contact_number,
            'awards' => $request->awards,
            'clinic_name' => $request->clinic_name,
            'image_picture' => $imagePath,
            'certificates' => json_encode($certificatePaths),
        ]);

        event(new Registered($user));
        Auth::login($user);

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->route('terms.show');
    }
}
