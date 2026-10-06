<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        // Ingat tujuan setelah login (mis. FE booking page) agar callback bisa
        // mengembalikannya. Hanya simpan URL yang aman (relative atau FRONTEND_URL).
        $redirect = $request->query('redirect');
        if ($redirect && $this->isSafeRedirect($redirect)) {
            $request->session()->put('google_redirect', $redirect);
        }

        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if (! $googleUser->getEmail()) {
                return redirect()->route('login')
                    ->with('error', 'Login Google gagal: email tidak diberikan oleh Google.');
            }

            // Cek user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (! $user) {
                // Buat user baru
                $user = User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: $googleUser->getEmail(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(uniqid()),
                    'email_verified_at' => now(),
                ]);

                // Jangan fatal jika role 'user' belum di-seed.
                if (Role::where('name', 'user')->exists()) {
                    $user->assignRole('user');
                } else {
                    Log::warning('Google login: role [user] missing, skipping assignRole.', [
                        'email' => $user->email,
                    ]);
                }
            } else {
                // Tautkan google_id / avatar yang belum tersimpan (kolom google_id
                // sebelumnya tidak fillable sehingga tidak pernah tersimpan).
                $dirty = false;
                if (empty($user->google_id) && $googleUser->getId()) {
                    $user->google_id = $googleUser->getId();
                    $dirty = true;
                }
                if (empty($user->avatar) && $googleUser->getAvatar()) {
                    $user->avatar = $googleUser->getAvatar();
                    $dirty = true;
                }
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = now();
                    $dirty = true;
                }
                if ($dirty) {
                    $user->save();
                }
            }

            Auth::login($user);
            $request->session()->regenerate();

            // Kembali ke FE jika login dimulai dari sana (?redirect=...).
            $redirect = $request->session()->pull('google_redirect');
            if ($redirect && $this->isSafeRedirect($redirect)) {
                return redirect($redirect);
            }

            return redirect()->route('dashboard.index');
        } catch (\Exception $e) {
            // Catat pesan asli (mis. invalid_state, redirect_uri_mismatch di sisi
            // token exchange) agar bisa didiagnosis via storage/logs/laravel.log.
            Log::warning('Google login failed: '.$e->getMessage(), [
                'exception' => get_class($e),
            ]);

            return redirect()->route('login')
                ->with('error', 'Login Google gagal. Pastikan redirect URI terdaftar di Google Console, lalu coba lagi.');
        }
    }

    /**
     * Hanya izinkan redirect relative ("/...") atau di bawah FRONTEND_URL
     * untuk mencegah open-redirect.
     */
    private function isSafeRedirect(string $url): bool
    {
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        $frontend = rtrim((string) env('FRONTEND_URL', ''), '/');
        if ($frontend !== '' && str_starts_with($url, $frontend)) {
            return true;
        }

        return false;
    }
}
