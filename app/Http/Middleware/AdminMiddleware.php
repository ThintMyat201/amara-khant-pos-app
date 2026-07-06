<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        // Get fresh user data from database
        $dbUser = \DB::table('users')->where('email', $user->email)->first();
        
        \Log::info('User role check:', [
            'email' => $user->email,
            'role_from_auth' => $user->role,
            'role_from_db' => $dbUser->role,
            'exact_comparison' => [
                'role_value' => $user->role,
                'equals_Admin' => $user->role === 'Admin',
                'equals_admin' => $user->role === 'admin'
            ]
        ]);
        
        if ($dbUser && ($dbUser->role === 'Admin' || $dbUser->role === 'admin')) {
            return $next($request);
        }
        
        // Non-admin: redirect to Sales instead of 403 (so "remember me" + direct URL give a smooth experience)
        return redirect()->route('sale.products');
    }
}
