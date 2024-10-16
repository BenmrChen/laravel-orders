<?php
namespace App\Http\Middleware;

use Closure;

class SwooleReloadMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (app()->environment('local')) {
            app('swoole.server')->reload();
        }

        return $response;
    }
}
