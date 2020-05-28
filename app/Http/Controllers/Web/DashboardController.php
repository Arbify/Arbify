<?php

namespace Arbify\Http\Controllers\Web;

use Arbify\Http\Controllers\Controller;
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
