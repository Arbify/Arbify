<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Contracts\Arb\ArbExporter;
use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Http\Controllers\BaseController;
use Arbify\Http\Requests\ExportLanguage;
use Arbify\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends BaseController
{
    private LanguageRepository $languageRepository;
    private ArbExporter $exporter;

    public function __construct(LanguageRepository $languageRepository, ArbExporter $exporter)
    {
        $this->languageRepository = $languageRepository;
        $this->exporter = $exporter;

        $this->middleware('verified');
        $this->authorizeResource(Project::class);
    }

    protected function resourceAbilityMap(): array
    {
        return [
            'export' => 'view',
            'exportAll' => 'view',
            'exportLanguage' => 'view',
        ];
    }


    public function show(Project $project): View
    {
        return view('projects.export', [
            'project' => $project,
        ]);
    }

    public function all(Project $project): Response
    {
        $languages = $this->languageRepository->allInProject($project);

        return $this->exporter->getDownloadResponse(
            $this->exporter->exportLanguages($project, $languages, ArbExporter::ARCHIVE_ZIP)
        );
    }

    public function language(ExportLanguage $request, Project $project): Response
    {
        $language = $this->languageRepository->byId($request->input('language'));

        return $this->exporter->getDownloadResponse(
            $this->exporter->exportLanguage($project, $language)
        );
    }
}
