<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Modules\API\Http\Middleware\CheckTokenExpirationMiddleware;
use Modules\Core\App\Http\Middleware\AdminPermissionsMiddleware;
use Modules\Core\App\Http\Middleware\SetApiLocale;
use Modules\Core\App\Http\Middleware\SetLocale;
use Modules\Mps\Http\Middleware\CompanyInfoMiddleware;
use Modules\Mps\Http\Middleware\KVKKMiddleware;
use Modules\Mps\Http\Middleware\ResetPasswordMiddleware;
use Modules\ResetFullAPI\Http\Middleware\ResolveUserFromClient;
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
            'admin' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'admin-enabled' => AdminEnabled::class,
            'audit' => AuditLogMiddleware::class,
            'authorize' => AdminPermissionsMiddleware::class,
            'setLocale' => SetLocale::class,
            'expiredToken' => CheckTokenExpirationMiddleware::class,
            'setApiLocale' => SetApiLocale::class,
            'passwordExpired' => ResetPasswordMiddleware::class,
            'kvkkVerify' => KVKKMiddleware::class,
            'companyLogoVerify' => CompanyInfoMiddleware::class,
            'resolveClientUser' => ResolveUserFromClient::class,
        ]);
        $middleware->append([

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
