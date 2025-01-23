<?php

namespace App\Http\Middleware;

use App\Models\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class LoadNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('user_id')) {
            $userId = Session::get('user_id');
            $unreadNotifications = Users::find($userId)->unreadNotifications()->latest()->limit(5)->get();

            // Share the unread notifications globally
            View::share('unreadNotifications', $unreadNotifications);
        }
        return $next($request);
    }
}
