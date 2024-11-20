<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validate inputs with custom error bag
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => [
                'required',
                'current_password', // Built-in Laravel validation for matching current password
            ],
            'password' => [
                'required',
                Password::defaults(), // Validates the strength of the password
                'confirmed', // Ensures 'password' and 'password_confirmation' match
            ],
        ]);

        try {
            // Update user's password
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);

            // Redirect with success message
            return back()->with('status', 'Password updated successfully.');
        } catch (\Exception $e) {
            // Catch any unexpected error and log if necessary
            return back()->withErrors([
                'updatePassword' => 'An error occurred while updating the password. Please try again.',
            ]);
        }
    }
}
