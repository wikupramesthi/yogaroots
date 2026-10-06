<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Faq;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * HP (User-Agent mobile) mendapat versi mobile phone-frame agar tampilannya
     * sama dengan halaman member mobile; desktop/admin tetap versi penuh.
     */
    public function create(): View
    {
        $faqs = Faq::where('status', 'active')
            ->orderBy('created_at', 'asc')
            ->get();
        $jumlahInstruktur       = User::role('instruktur')->count();
        $jumlahMembers       = User::role('user')->count();

        if ($this->isMobile()) {
            return view('auth.login-mobile');
        }

        return view('auth.login', compact('faqs', 'jumlahInstruktur', 'jumlahMembers'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $welcome = $request->user()->hasRole('user')
            ? 'Welcome back! Happy practicing.'
            : 'Welcome to the admin page!';

        return redirect()
            ->intended(route('dashboard.index', absolute: false))
            ->with('success', $welcome);
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

    /**
     * Deteksi HP dengan pola yang sama seperti controller member mobile
     * (Dashboard, Profile, Package, Instruktur, Checkout).
     */
    private function isMobile(): bool
    {
        return (bool) preg_match(
            '/Mobile|Android|iPhone|iPad|iPod/i',
            (string) request()->header('User-Agent')
        );
    }
}
