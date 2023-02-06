<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserRole;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\RolePermission;

class Payroll
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
        $empID=auth()->user()->id;
        $role=UserRole::where('user_id',$empID)->first();
        $role_id=$role->role_id;
        $permission=Permission::where('slug','view-payroll')->first();
        $role_permision=RolePermission::where('role_id',$role_id)->where('permission_id',$permission->id)->first();
        
        if ($role_permision) {
            return $next($request);
        }

        return redirect('flex/errors');
    }
}
