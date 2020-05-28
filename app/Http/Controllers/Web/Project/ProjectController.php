<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Http\Controllers\Controller;
use Arbify\Contracts\Arb\ArbExporter;
use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Contracts\Repositories\ProjectRepository;
use Arbify\Http\Requests\ExportLanguage;
use Arbify\Http\Requests\StoreProject;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Settings;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    private ProjectRepository $projectRepository;
    private LanguageRepository $languageRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        LanguageRepository $languageRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->languageRepository = $languageRepository;

        $this->middleware('verified');
        $this->authorizeResource(Project::class);
    }

    protected function resourceAbilityMap(): array
    {
        return parent::resourceAbilityMap() + [
                'export' => 'view',
                'exportAll' => 'view',
                'exportLanguage' => 'view',
            ];
    }

    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->can('view-private', Project::class)) {
            $projects = $this->projectRepository->allPaginated();
        } else {
            $projects = $this->projectRepository->visibleToUserPaginated($user);
        }

        $statistics = [];
        foreach ($projects as $project) {
            $statistics[$project->id] = $this->projectRepository->translationStatistics($project);
        }

        return view('projects.index', [
            'projects' => $projects,
            'statistics' => $statistics,
        ]);
    }

    public function create(): View
    {
        return view('projects.form');
    }

    public function store(StoreProject $request): Response
    {
        $project = Project::create($request->validated());
        $project->projectMembers()->create([
            'role' => ProjectMember::ROLE_LEAD,
            'user_id' => $request->user()->id,
        ]);

        // Add default language
        $project->languages()->attach(Settings::defaultLanguage());

        return redirect()->route('projects.index')
            ->with('success', "Added <b>$project->name</b> successfully.");
    }

    public function show(Project $project): View
    {
        return view('projects.show', [
            'project' => $project,
        ]);
    }

    public function edit(Project $project): View
    {
        return view('projects.form', [
            'project' => $project
        ]);
    }

    public function update(StoreProject $request, Project $project): Response
    {
        $project->update($request->validated());

        return redirect()->route('projects.index')
            ->with('success', "Updated <b>$project->name</b> successfully.");
    }

    public function destroy(Project $project): Response
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', "Deleted <b>$project->name</b> successfully.");
    }

    public function export(Project $project): View
    {
        return view('projects.export', [
            'project' => $project,
        ]);
    }

    public function exportAll(
        Project $project,
        ArbExporter $exporter
    ): Response {
        $languages = $this->languageRepository->allInProject($project);

        return $exporter->getDownloadResponse(
            $exporter->exportLanguages($project, $languages, ArbExporter::ARCHIVE_ZIP)
        );
    }

    public function exportLanguage(
        ExportLanguage $request,
        Project $project,
        ArbExporter $exporter
    ): Response {
        $language = $this->languageRepository->byId($request->input('language'));

        return $exporter->getDownloadResponse(
            $exporter->exportLanguage($project, $language)
        );
    }
}
