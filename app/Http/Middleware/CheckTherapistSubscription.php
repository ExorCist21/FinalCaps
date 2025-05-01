<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckTherapistSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if therapist and session_left is <= 0
        if ($user->role === 'therapist' && $user->session_left <= 0) {
            // Allow only access to subscriptions and logout routes
            if (
                !$request->is('subscriptions') && 
                !$request->is('subscriptions/*') &&
                !$request->is('logout')
            ) {
                return redirect()->route('subscription.lock');
            }
        }

        return $next($request);
    }
}
