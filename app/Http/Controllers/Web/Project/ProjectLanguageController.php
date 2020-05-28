<?php

namespace App\Http\Controllers\Web\Project;

use App\Http\Controllers\Controller;
use App\Contracts\Repositories\LanguageRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Http\Requests\AddLanguageToProject;
use App\Models\Language;
use App\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProjectLanguageController extends Controller
{
    private LanguageRepository $languageRepository;
    private ProjectRepository $projectRepository;

    public function __construct(
        LanguageRepository $languageRepository,
        ProjectRepository $projectRepository
    ) {
        $this->languageRepository = $languageRepository;
        $this->projectRepository = $projectRepository;

        $this->middleware('verified');
        $this->authorizeResource(Project::class);
    }

    protected function resourceAbilityMap(): array
    {
        return [
            'index' => 'view',
            'create' => 'manage-languages',
            'store' => 'manage-languages',
            'destroy' => 'manage-languages',
        ];
    }


    public function index(Project $project): View
    {
        $languages = $this->languageRepository->allInProject($project);
        $statistics = $this->projectRepository->translationStatistics($project);

        return view('projects.languages.index', [
            'project' => $project,
            'languages' => $languages,
            'statistics' => $statistics,
        ]);
    }

    public function create(Project $project): View
    {
        $languages = $this->languageRepository->allExceptAlreadyInProject($project);

        return view('projects.languages.add', [
            'project' => $project,
            'languages' => $languages,
        ]);
    }

    public function store(AddLanguageToProject $request, Project $project): Response
    {
        $language = $this->languageRepository->byId($request->input('language'));
        $project->languages()->syncWithoutDetaching($language);

        return redirect()->route('project-languages.index', $project)
            ->with('success', "Added <b>$language->code</b> to <b>$project->name</b> successfully.");
    }

    public function destroy(Project $project, Language $language): Response
    {
        $project->languages()->detach($language);

        return redirect()->route('project-languages.index', $project)
            ->with('success', "Deleted <b>$language->code</b> from <b>$project->name</b> successfully.");
    }
}
