<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasswordExpireationMiddleware
{
    
     public function handle($request, Closure $next)
    {
        $lastPasswordChange = $this->password_age(Auth::user()->emp_id);

        $expirationPeriod = now()->subDays(90);

        if ($lastPasswordChange < $expirationPeriod) {
            return redirect('/change-password');
        }

        return $next($request);
    }

    private function password_age($empID)
    {
        $query = DB::table('user_passwords')->select('time')->where('empID', $empID)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->first();

        return $query ? $query->time : '0';
    }
}
