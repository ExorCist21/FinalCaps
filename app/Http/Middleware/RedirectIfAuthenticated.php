<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Role-based redirection
                return match ($user->role) {
                    'therapist' => redirect()->route('therapist.dashboard'),
                    'patient' => redirect()->route('patients.dashboard'),
                    'admin' => redirect()->route('admin.dashboard'),
                    default => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}