<?php

namespace App\Helpers;

use App\Models\AuditTrail;
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
    public static function AuditLog( $action, Request $request)
    {

        AuditTrail::create([
            'empID' => Auth::user()->emp_id,
            'platform' => 'Windows 10',
            'description' => $action,
            'ip_address' =>  $request->ip(),
            'agent' => 'Chrome',
            'due_date' => date('Y-m-d H:i:s'),
        ]);
    }
}
