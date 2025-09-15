<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\FailedLoginResponse;
use App\Models\User;

class AuthenticateUser
{
    public function __invoke($request)
    {
        $this->ensureIsNotRateLimited($request);

        // Validar que el usuario exista y esté activo
        $user = User::where('email', $request->email)->first();

        if ($user && $user->estado == 0) {
            throw ValidationException::withMessages([
                'email' => __('Tu cuenta está inactiva. Contacta al administrador.'),
            ]);
        }

        if (! Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => __('Las credenciales no son válidas.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        return app(LoginResponse::class);
    }

    protected function ensureIsNotRateLimited($request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => __('Demasiados intentos. Intenta de nuevo en :seconds segundos.', [
                'seconds' => RateLimiter::availableIn($this->throttleKey($request)),
            ]),
        ]);
    }

    protected function throttleKey($request)
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }
}
