<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function home()
    {
        return view('errors.404');
    }

    /**
     * Extra Pages that were required
     */

    /**
     * Feedback View
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function faq()
    {
        return view('extra.feedback');
    }

    /**
     * Knowledge View
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function knowledge()
    {
        return view('extra.knowledge');
    }
}
