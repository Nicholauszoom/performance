<?php

namespace App\Http\Controllers;

use App\Helpers\SysHelpers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public static function AuditLog($risk, $action, $ip)
    {
        // AuditTrail::create([
        //     'user_id' => Auth::user()->id,
        //     'user_email' => Auth::user()->email,
        //     'user_name' => Auth::user()->name,
        //     'action_performed' => $action,
        //     'ip_address' => $ip,
        //     'risk' => $risk
        // ]);

    }

    public function test(Request $request)
    {


    }
}
