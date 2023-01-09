<?php

namespace App\Helpers;

use App\Models\AuditTrail;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SysHelpers
{

    /**
     * Funtion for creating audit logs for every action that has to be perfromed
     * inside the performance system
     *
     * risk [1-High, 2-mdeium, 3-low]
     * action [Actions to be performed inside the system]
     * ip of the machine that is being used
     *
     * @param int $risk
     * @param string $action
     * @param string $ip
     * @return void
     */
    public static function AuditLog( $risk, $action, Request $request)
    {
        $employee = Auth::user()->fname. ' ' .Auth::user()->mname. ' ' .Auth::user()->lname;

        AuditTrail::create([
            'emp_id' => Auth::user()->emp_id,
            'emp_name' => $employee,
            'action_performed' => $action,
            'ip_address' =>  $request->ip(),
            'user_agent' => $request->userAgent(),
            'risk' => $risk,
        ]);
    }

}
