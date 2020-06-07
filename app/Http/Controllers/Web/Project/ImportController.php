<?php

declare(strict_types=1);

namespace Arbify\Http\Controllers\Web\Project;

use Albert221\Filepond\Filepond;
use Arbify\Arb\Importer\ArbImporter;
use Arbify\Arb\Importer\ImportException;
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
        $overrideMessageValues = (bool)$request->input('override_message_values');

        foreach ($files as $i => $file) {
            try {
                $importer->import($project, $file, $request->user(), $overrideMessageValues);
            } catch (ImportException $e) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "files.$i" => sprintf(
                            '<p class="mb-1"><b>%s:</b> %s</p><p class="mb-0 text-secondary">%s</p>',
                            $file->getClientOriginalName(),
                            $e->getMessage(),
                            $e->getSolution()
                        )
                    ]);
            }
        }

        return redirect()->route('messages.index', $project)
            ->with('success', 'File(s) successfully imported.');
    }
}
