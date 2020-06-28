<?php

declare(strict_types=1);

namespace Arbify\Http\Controllers\Web;

use Arbify\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class FilepondController extends BaseController
{
    public function __construct()
    {
        $this->middleware('verified');
    }

//    public function load(Request $request)
//    {
//        $id = $request->query('id');
//    }
}
