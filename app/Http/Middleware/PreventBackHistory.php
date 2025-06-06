<?php

namespace App\Http\Middleware;

use Closure;

class PreventBackHistory
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (method_exists($response, 'header')) {
            return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        }
        // return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
        //                 ->header('Pragma', 'no-cache')
        //                 ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
            return $response;

    }
}
