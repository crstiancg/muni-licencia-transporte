<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\AuthenticateUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::authenticateUsing(function ($request) {
            $user = User::where('email', $request->email)->first();

            // Verificar si el usuario existe y está activo
            if ($user &&
                $user->estado == 1 &&
                Hash::check($request->password, $user->password)) {
                return $user; // ✅ Devuelve el usuario: se loguea correctamente
            }

            // ❌ Devuelve null: el login falla
            return null;
        });
    }
}
