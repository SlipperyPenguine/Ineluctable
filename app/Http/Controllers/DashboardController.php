<?php

namespace ineluctable\Http\Controllers;

use Illuminate\Http\Request;

use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     *
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     *
     * param [ mixed $args [, $... ]]
     * @return void
     * @link http://php.net/manual/en/language.oop5.decon.php
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        return view('dashboard.home');
    }
}
