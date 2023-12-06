<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        //\Illuminate\Http\Middleware\EnsureHttpHeaders::class,
        \App\Http\Middleware\EnsureHttpHeaders::class,
        \App\Http\Middleware\SecureHeaders::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\CheckSession::class,
        ],

        'api' => [
            // // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // 'throttle:api',
            // \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,

            // 'throttle:api',

            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
        'workforce' => \App\Http\Middleware\WorkForce::class, //workforce management middleware
        'payroll' => \App\Http\Middleware\Payroll::class, // Payroll management access middleware
        'employee' => \App\Http\Middleware\Employee::class, // For Employee related issues
        'suspension' => \App\Http\Middleware\EmployeeSuspension::class, // For Employee Suspension
        'leave' => \App\Http\Middleware\Leave::class, // For Employee leave
        'loan' => \App\Http\Middleware\Loan::class, // For Loan Management
        'organisation' => \App\Http\Middleware\Organisation::class, // For Organisation Management
        'report' => \App\Http\Middleware\Report::class, // For Report
        'setting' => \App\Http\Middleware\Setting::class, // For Report
        'dashboard' => \App\Http\Middleware\Dashboard::class, // For Dashboard
        'emptermination' => \App\Http\Middleware\EmployeeTermination::class, // For Employee Termination
        'promotion' => \App\Http\Middleware\Promotion::class, // For Employee Promotion
        'verify-outgoing-requests' => \App\Http\Middleware\VerifyOutgoingRequests::class,
        // 'check.session' => \App\Http\Middleware\CheckSession::class,

    ];
}
