<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Contracts\Arb\ArbExporter;
use App\Contracts\Repositories\MessageValueRepository;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;

class ProjectArbController extends Controller
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
