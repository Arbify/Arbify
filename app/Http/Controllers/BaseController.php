<?php

namespace Arbify\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as XController;

class BaseController extends XController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
