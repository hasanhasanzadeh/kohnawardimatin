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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \RealRashid\SweetAlert\ToSweetAlert::class,
            App\Http\Middleware\LangLocale::class,
            App\Http\Middleware\ConvertPersianNumbers::class,
        ]);
        $middleware->alias([
            'LangLocale' => App\Http\Middleware\LangLocale::class,
            'Alert' => RealRashid\SweetAlert\SweetAlertServiceProvider::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            '/panel/upload-image' // <-- exclude this route
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
