<?php

use App\Http\Middleware\PreventBackHistory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Prevent the browser from caching authenticated pages.
        // Without this, hitting the back button after logout can reveal
        // previously-visited authenticated pages from the browser's cache.
        $middleware->alias([
            'no.cache' => PreventBackHistory::class,
        ]);

        $middleware->appendToGroup('web', [
            PreventBackHistory::class,
        ]);

        // Redirect unauthenticated users (expired/closed-browser sessions)
        // to the public homepage instead of the default /login page.
        $middleware->redirectGuestsTo(fn () => route('home'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
