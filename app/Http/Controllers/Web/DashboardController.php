<?php

namespace Arbify\Http\Controllers\Web;

use Arbify\Http\Controllers\BaseController;
use Illuminate\View\View;

class DashboardController extends BaseController
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
