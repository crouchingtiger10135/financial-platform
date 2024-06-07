<?php 

// app/Http/Middleware/InvitationAccess.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InvitationAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Allow access to invitation form and completion route
        if ($request->route()->named('invitations.complete') || $request->route()->named('invitations.complete.post')) {
            return $next($request);
        }

        // Restrict access to authenticated users for other routes
        if (Auth::check()) {
            return $next($request);
        }

        // Redirect to login if not authenticated
        return redirect()->route('login');
    }
}
