<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->is_driver) {
                return redirect()->route('driver.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
