<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Modules\Core\App\Http\Middleware\AdminPermissionsMiddleware;
use Modules\Core\app\Http\Middleware\ComingSoon;
use Modules\Core\App\Http\Middleware\SetApiLocale;
use Modules\Core\App\Http\Middleware\SetLocale;
use Modules\Doctor\Http\Middleware\DoctorMenu;
use Modules\UserManagement\app\Http\Middleware\AdminEnabled;
use Modules\UserManagement\app\Http\Middleware\AuditLogMiddleware;
use Modules\UserManagement\Http\Middleware\Authenticate;
use Modules\UserManagement\Http\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'doctor' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'admin-enabled' => AdminEnabled::class,
            'audit' => AuditLogMiddleware::class,
            'authorize' => AdminPermissionsMiddleware::class,
            'setLocale' => SetLocale::class,
            'setApiLocale' => SetApiLocale::class,
            'coming_soon' => ComingSoon::class,
            'doctorMenu' => DoctorMenu::class,
        ]);
        $middleware->append([

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
