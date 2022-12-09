<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $permission = DB::table('permission')->get();

        Session::put('name', $permission);

        // dd(Session::get('name'));

        return view('app.home');
    }
}
