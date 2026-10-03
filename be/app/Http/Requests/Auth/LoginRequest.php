<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Services\Security\BruteForceProtector;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        // Blokir sementara ala DBMSDA: cek lockout IP/email sebelum mencoba.
        $protector = app(BruteForceProtector::class);
        $lockout = $protector->isLocked($this->ip(), $this->input('email'));

        if ($lockout) {
            throw ValidationException::withMessages([
                'email' => $protector->lockedMessage($lockout),
            ]);
        }

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // Listener RecordFailedLogin mencatat ke DB via event Failed.
            // Jika percobaan ini memicu lockout, tampilkan pesan blokir langsung.
            $freshLockout = $protector->isLocked($this->ip(), $this->input('email'));

            if ($freshLockout) {
                throw ValidationException::withMessages([
                    'email' => $protector->lockedMessage($freshLockout),
                ]);
            }

            $remaining = max(0, $protector->maxAttempts() - RateLimiter::attempts($this->throttleKey()));

            throw ValidationException::withMessages([
                'email' => $remaining > 0
                    ? trans('auth.failed') . " Sisa kesempatan: {$remaining} kali sebelum akun/IP diblokir sementara."
                    : trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
