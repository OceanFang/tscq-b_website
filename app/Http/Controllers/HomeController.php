<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'request.log']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startDate = (!$request->start) ? date('Y-m-d') : $request->start;
        $endDate = (!$request->end) ? date('Y-m-d') : $request->end;

        return view('home', compact('startDate', 'endDate'));
    }
}
