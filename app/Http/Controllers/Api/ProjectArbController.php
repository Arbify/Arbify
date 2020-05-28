<?php

declare(strict_types=1);

namespace Arbify\Http\Controllers\Api;

use Arbify\Contracts\Arb\ArbExporter;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Http\Controllers\BaseController;
use Arbify\Models\Language;
use Arbify\Models\Project;
use Symfony\Component\HttpFoundation\Response;

class ProjectArbController extends BaseController
{
    private ArbExporter $exporter;

    public function __construct(ArbExporter $exporter)
    {
        $this->exporter = $exporter;

        $this->authorizeResource(Project::class);
    }

    protected function resourceAbilityMap(): array
    {
        return [
            'index' => 'view',
            'show' => 'view',
        ];
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return [];
    }


    public function index(Project $project, MessageValueRepository $messageValueRepository): array
    {
        return $messageValueRepository->languageGroupedDetailsByProject($project);
    }

    public function show(Project $project, Language $language): Response
    {
        return $this->exporter->getDownloadResponse(
            $this->exporter->exportLanguage($project, $language)
        );
    }
}
