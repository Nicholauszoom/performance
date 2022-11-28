<?php

namespace App\Helpers;

class SysHelpers
{

    public function AuditLog($request, $risk, $action)
    {
        // $audit = new AuditTrail;

        // $audit->user_id = Auth::user()->id;
        // $audit->username = Auth::user()->username;
        // $audit->fullname = Auth::user()->firstname.' '.Auth::user()->middlename.' '.Auth::user()->surname;

        // $audit->action_performed = $action;

        // $audit->risk = $risk;

        // $audit->ip_address = $request->ip();
        // $audit->save();

    }
}
