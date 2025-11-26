<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register route middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Log terstruktur untuk error tak tertangani (abaikan saat CLI)
        $exceptions->report(function (\Throwable $e): void {
            if (app()->runningInConsole()) {
                return;
            }

            Log::error('Unhandled exception', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'url' => optional(request())->fullUrl(),
                'user_id' => optional(auth()->user())->id,
                'user_role' => optional(auth()->user())->role,
            ]);
        });
    })->create();
