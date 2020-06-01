<?php

declare(strict_types=1);

namespace Arbify\Http\Controllers\Api\Project;

use Arbify\Contracts\Arb\ArbExporter;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Http\Controllers\BaseController;
use Arbify\Models\Language;
use Arbify\Models\Project;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends BaseController
{
    private ArbExporter $exporter;

    public function __construct(ArbExporter $exporter)
    {
        $this->exporter = $exporter;

        $this->middleware('verified');
    }

    public function index(Project $project, MessageValueRepository $messageValueRepository): array
    {
        $this->authorize('view', $project);

        return $messageValueRepository->languageGroupedDetailsByProject($project);
    }

    public function show(Project $project, Language $language): Response
    {
        $this->authorize('view', $project);

        return $this->exporter->getDownloadResponse(
            $this->exporter->exportLanguage($project, $language)
        );
    }
}
