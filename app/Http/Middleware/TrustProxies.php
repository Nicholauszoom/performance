<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Closure;
use App\Models\UserRole;
use App\Models\Permission;
use App\Models\BrandSetting;



use Symfony\Component\HttpFoundation\BinaryFileResponse;


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
           $cookieValue = '123';
           $path = '/';
           $secure = true;
           $httpOnly = true;
           $sameSite = 'lax';

            $response = $next($request);

            $brands = BrandSetting::all();


            if (!($response instanceof BinaryFileResponse)) {

            foreach($brands as $brand){
                $response->header('Content-Security-Policy', $brand->allowed_domain);
            }

            $response->header('X-Frame-Options', 'DENY');
            $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('Referrer-Policy', 'no-referrer-when-downgrade');
            $response->header('Permissions-Policy', 'no-referrer-when-downgrade');
            $response->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
            $response->cookie('__Host-sess', $cookieValue, 0, $path, null, $secure, $httpOnly, $sameSite);
            }


            return $response;

        }
}
