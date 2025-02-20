<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('dashboard') || $request->is('foto/*') && $request->isMethod('GET')) {
            return $next($request);
        }

        if (!session()->has('user_id')) {
            return redirect()->route('auth.login.show')->with(['need_login' => 'You must be logged in to access this page.']);
        }

        if ($request->is('admin/*')) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
