<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsNotVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        if ($request->user() instanceof MustVerifyEmail && $request->user()->hasVerifiedEmail())
        {
            $user = $request->user();

            if ($user->role == 'volunteer')
            {
                return redirect()->route('volunteer.events.index');
            }
            else if ($user->role == 'organization')
            {
                return redirect()->route('organization.events.index');
            }
            else if ($user->role == 'admin')
            {
                return redirect()->route('admin.events.index');
            }
        }

        return $next($request);
    }
}
