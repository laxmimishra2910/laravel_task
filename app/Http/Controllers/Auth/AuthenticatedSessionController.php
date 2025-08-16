<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Jobs\UpdateProfileStatus;

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

           // Get logged-in user
    $user = Auth::user();

    // Dispatch job to update profile status
   if ($user->profile) {
    $status = $user->role === 'admin' ? 'inactive' : 'active';
    UpdateProfileStatus::dispatch([$user->profile->id], $status);
}

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
           $user = Auth::user();

    if ($user && $user->profile) {
        UpdateProfileStatus::dispatch([$user->profile->id], 'offline');
    }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        

        return redirect('/');
    }
}
