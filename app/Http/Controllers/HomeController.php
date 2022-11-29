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

}
