<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Throwable;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user && ($user->role == 'Admin' || $user->role == 'admin')) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('sale.products');
    }

    /**
     * Automatically authenticate a demo Admin account for quick testing.
     */
    public function demoLogin(Request $request): RedirectResponse
    {
        try {
            $demoUser = User::firstOrCreate(
                ['email' => 'demo@pos.com'],
                [
                    'name' => 'Demo Admin',
                    'password' => Hash::make('demo123!@#'),
                    'role' => 'Admin',
                    'phone' => '09880001025',
                    'address' => 'Jalan PBS 14/2, Taman Perindustrian Bukit Serdang, 43300 Seri Kembangan, Selangor',
                ]
            );

            if ($demoUser->role !== 'Admin' && $demoUser->role !== 'admin') {
                $demoUser->update(['role' => 'Admin']);
            }
        } catch (Throwable $e) {
            $demoUser = User::whereIn('email', ['demo@pos.com', 'admin@pos.com', 'admin123@gmail.com'])
                ->orWhereIn('role', ['Admin', 'admin'])
                ->first();

            if (! $demoUser) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Unable to initialize the demo account. Please verify database connectivity.',
                ]);
            }
        }

        Auth::login($demoUser);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
