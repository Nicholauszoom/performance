<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Helpers\SysHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditTrailController extends Controller
{

    public function auditLog($risk, $action, $ip)
    {
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->email,
            'user_name' => Auth::user()->name,
            'action_performed' => $action,
            'ip_address' => $ip,
            'risk' => $risk
        ]);
    }
}
