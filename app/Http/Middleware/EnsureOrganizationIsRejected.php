<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationIsRejected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->organization)
        {
            Auth::logout();
 
            $request->session()->invalidate();
        
            $request->session()->regenerateToken();
        
            return redirect()->route('guest.index');
        }
        else if ($request->user()->organization->state == 'pending')
        {
            return redirect()->route('organization.waiting.pending');
        }
        else if ($request->user()->organization->state == 'approved')
        {
            return redirect()->route('organization.events.index');
        }

        return $next($request);
    }
}
