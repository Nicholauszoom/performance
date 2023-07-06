<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\UserRole;

class EmployeeTermination
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
        $permission=Permission::where('slug','view-termination')->first();
        $role_permision=RolePermission::where('role_id',$role_id)->where('permission_id',$permission->id)->first();

        if ($role_permision) {
            return $next($request);
        }

        abort(Response::HTTP_UNAUTHORIZED);
     }
}
