<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Http\Controllers\BaseController;
use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Contracts\Repositories\ProjectRepository;
use Arbify\Http\Requests\AddLanguagesToProject;
use Arbify\Models\Language;
use Arbify\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProjectLanguageController extends BaseController
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

    public function store(AddLanguagesToProject $request, Project $project): Response
    {
        $languages = $this->languageRepository->byIds($request->input('languages'));
        $project->languages()->syncWithoutDetaching($languages);

        $codes = $languages->map(fn(Language $language) => $language->code)->implode('</b>, <b>');

        return redirect()->route('project-languages.index', $project)
            ->with('success', "Added <b>$codes</b> to <b>$project->name</b> successfully.");
    }

    public function destroy(Project $project, Language $language): Response
    {
        $project->languages()->detach($language);

        return redirect()->route('project-languages.index', $project)
            ->with('success', "Deleted <b>$language->code</b> from <b>$project->name</b> successfully.");
    }
}
