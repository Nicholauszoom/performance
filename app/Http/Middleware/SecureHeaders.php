<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cookieValue = '123';
           $path = '/';
           $secure = true;
           $httpOnly = true;
           $sameSite = 'lax';
        //return $next($request);
        $response = $next($request);

        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        $response->header('X-XSS-Protection', '1; mode=block');
        $response->header('Content-Security-Policy', 'https://hc-uat.bancabc.co.tz');
        $response->header('Content-Security-Policy', 'https://hc-hub.bancabc.co.tz');
        $response->header('Content-Security-Policy', 'https://int.cits.co.tz');
        $response->cookie('__Host-sess', $cookieValue, 0, $path, null, $secure, $httpOnly, $sameSite);


        return $response;
    }
}
