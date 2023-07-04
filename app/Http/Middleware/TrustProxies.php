<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Closure;
use App\Models\UserRole;
use App\Models\Permission;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;

        public function handle(Request $request, Closure $next)
        {

            $response = $next($request);
            $response->header('Content-Security-Policy', 'https://hc-hub.bancabc.co.tz');
            $response->header('X-Frame-Options', 'SAMEORIGIN');
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('Referrer-Policy', 'no-referrer-when-downgrade');
            $response->header('Permissions-Policy', 'no-referrer-when-downgrade');
            $response->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');






            return $response;

        }
}
