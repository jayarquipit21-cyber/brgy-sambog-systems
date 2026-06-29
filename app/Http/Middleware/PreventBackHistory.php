<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * Adds HTTP headers that instruct browsers and proxies never to cache
     * the response. This prevents authenticated pages from being served
     * from the browser's back/forward cache after the user has logged out.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        return $response->withHeaders([
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Pragma'        => 'no-cache',
            'Expires'       => 'Sun, 02 Jan 1990 00:00:00 GMT',
        ]);
    }
}
