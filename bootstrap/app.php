<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Modules\AdminManagement\Http\Middleware\AdminEnabled;
use Modules\AdminManagement\Http\Middleware\AdminMenu;
use Modules\AdminManagement\Http\Middleware\AuditLogMiddleware;
use Modules\AdminManagement\Http\Middleware\Authenticate;
use Modules\AdminManagement\Http\Middleware\RedirectIfAuthenticated;
use Modules\Core\App\Http\Middleware\AdminPermissionsMiddleware;
use Modules\Core\app\Http\Middleware\ComingSoon;
use Modules\Core\App\Http\Middleware\SetApiLocale;
use Modules\Core\App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // Default `auth` is overridden to our Authenticate middleware so
            // unauthenticated redirects go to `admin.login` (the only login
            // route that actually exists in this app) instead of the Laravel
            // default `route('login')` — which was throwing
            // RouteNotFoundException for every expired admin session on the
            // Website / Theme routes that use `middleware(['auth','verified'])`.
            'auth' => Authenticate::class,
            'admin-auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'admin-enabled' => AdminEnabled::class,
            'audit' => AuditLogMiddleware::class,
            'authorize' => AdminPermissionsMiddleware::class,
            'setLocale' => SetLocale::class,
            'setApiLocale' => SetApiLocale::class,
            'coming_soon' => ComingSoon::class,
            'adminMenu' => AdminMenu::class,
        ]);
        $middleware->append([

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
