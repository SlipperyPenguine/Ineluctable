<?php

namespace ineluctable\Http\Controllers;

use Illuminate\Http\Request;

use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;

class pagescontroller extends Controller
{

    /**
     * View for the home page
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {

        return view('home');

    }

    /**
     * View for functionality currently in development
     *
     * @return \Illuminate\View\View
     */
    public function indevelopment()
    {
        return view('indevelopment');
    }

    /**
     * Jump fatigue tool
     *
     * @return \Illuminate\View\View
     */
    public function jumpfatigue()
    {
        flash('Testing', 'This is a test');
        return view('tools.jumpfatigue');
    }

    /**
     * entosis link tool
     * @return \Illuminate\View\View
     */
    public function entosis()
    {
        return view('tools.entosis');
    }
}
