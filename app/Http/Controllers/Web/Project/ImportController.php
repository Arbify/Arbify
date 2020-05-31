<?php

declare(strict_types=1);

namespace Arbify\Http\Controllers\Web\Project;

use Albert221\Filepond\Filepond;
use Arbify\Arb\Importer\ArbImporter;
use Arbify\Http\Controllers\BaseController;
use Arbify\Http\Requests\ImportToProject;
use Arbify\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends BaseController
{
    public function __construct()
    {
        $this->middleware('verified');
        $this->authorizeResource(Project::class);
    }

    protected function resourceAbilityMap(): array
    {
        return [
            'show' => 'import',
            'upload' => 'import',
        ];
    }

    public function show(Project $project): View
    {
        return view('projects.import', [
            'project' => $project,
        ]);
    }

    public function upload(
        ImportToProject $request,
        Project $project,
        Filepond $filepond,
        ArbImporter $importer
    ): Response {
        $files = $filepond->fromRequest($request, 'files');
        $overrideMessageValues = (bool) $request->input('override_message_values');

        foreach ($files as $file) {
            $importer->import($project, $file, $overrideMessageValues);
        }

        $message = sprintf(
            'File(s) successfully imported. <a href="%s">Go to messages.</a>',
            route('messages.index', $project)
        );

        return redirect()->route('projects.import', $project)
            ->with('success', $message);
    }
}
