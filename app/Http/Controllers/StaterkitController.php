<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaterkitController extends Controller
{
    // home
    public function home()
    {
        
        return view('home');
    }
}
