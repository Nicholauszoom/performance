<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BrandSetting;


class VerifyOutgoingRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {

        $brands = BrandSetting::all();

        foreach($brands as $brand){
            $allowedDomains = [
                $brand->allowed_domain,
                // Add more allowed domains here
            ];

        }


        $url = $request->url();
        $domain = parse_url($url, PHP_URL_HOST);

        if (!in_array($domain, $allowedDomains)) {
            abort(403, 'Unauthorized domain.');
        }

        return $next($request);
    }
}
