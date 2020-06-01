<?php

declare(strict_types=1);

namespace Arbify\Http\Controllers\Api\Project;

use Arbify\Arb\Importer\ArbImporter;
use Arbify\Http\Controllers\BaseController;
use Arbify\Http\Requests\ImportToProject;
use Arbify\Models\Project;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends BaseController
{
    private ArbImporter $importer;

    public function __construct(ArbImporter $importer)
    {
        $this->importer = $importer;

        $this->middleware('verified');
    }

    public function import(ImportToProject $request, Project $project): Response
    {
        $this->authorize('import', $project);

        foreach ($request->file('files') as $file) {
            $this->importer->import($file);
        }

        return status(200);
    }
}
