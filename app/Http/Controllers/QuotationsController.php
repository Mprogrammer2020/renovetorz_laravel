<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuotationsController extends Controller
{
    function index(){
        return view('panel.quotations.index');
    }

    function dashboard(){
        return view('panel.quotations.dashboard');
    }

    function refrence(){
        return view('panel.quotations.refrence');
    }

    function stepper(){
        return view('panel.quotations.stepper');
    }
}
