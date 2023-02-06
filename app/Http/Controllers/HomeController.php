<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        // dd('You are active');
        return view('errors.404');
    }
}
