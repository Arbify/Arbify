<?php

declare(strict_types=1);

namespace Arbify\Http\Controllers\Web\Project;

use Albert221\Filepond\Filepond;
use Arbify\Http\Controllers\BaseController;
use Arbify\Http\Requests\ImportToProject;
use Arbify\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends BaseController
{
    public function show(Project $project): View
    {
        return view('projects.import', [
            'project' => $project,
        ]);
    }

    public function upload(ImportToProject $request, Filepond $filepond): Response
    {
        dump($filepond->fromRequest($request, 'file'));

        return back();
    }
}
