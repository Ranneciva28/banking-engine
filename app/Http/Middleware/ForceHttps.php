<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('production') && ! $request->secure()) {
            $base = rtrim((string) config('app.url'), '/');

            if (str_starts_with($base, 'https://')) {
                $target = $base.$request->getRequestUri();

                return redirect()->away($target, 301);
            }
        }

        return $next($request);
    }
}
