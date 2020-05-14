<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function __invoke(): View
    {
        return view('dashboard');
    }
}
