<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (Middleware $middleware): void {
   $middleware->alias([
        // 🔐 Auth & Security
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // 🧱 Session / CSRF / Routing
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    'substituteBindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'verify.csrf' => \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,

        // 📜 Cache & Headers
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'trim' => \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
    'convert.empty.strings' => \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    'prevent.requests.during.maintenance' => \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,

    'role' => \App\Http\Middleware\RoleMiddleware::class,

]);
})
->withExceptions(function (Exceptions $exceptions): void {
        //
})->create();
