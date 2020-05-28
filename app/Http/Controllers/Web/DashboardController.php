<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
