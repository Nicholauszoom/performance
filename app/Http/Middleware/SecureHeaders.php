<?php

namespace App\Http\Middleware;

use App\Models\BrandSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


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

        $brands = BrandSetting::all();

        if (!($response instanceof BinaryFileResponse)) {


        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        $response->header('X-XSS-Protection', '1; mode=block');
        foreach($brands as $brand ){
            $response->header('Content-Security-Policy', $brand->allowed_domain);
        }
        $response->cookie('__Host-sess', $cookieValue, 0, $path, null, $secure, $httpOnly, $sameSite);
        }

        return $response;
    }
}
