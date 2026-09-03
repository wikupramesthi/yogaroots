<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Faq;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $faqs = Faq::where('status', 'active')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('auth.login', compact('faqs'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()
            ->intended(route('dashboard.index', absolute: false))
            ->with('success', 'Welcome to the admin page!');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user(); // ambil dulu sebelum logout

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($user && in_array($user->role, ['admin', 'super-admin'])) {
            return redirect('auth/login');
        }

        return redirect('auth/login');
    }
}
