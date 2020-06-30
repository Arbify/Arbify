<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Contracts\Repositories\MessagesTranslationStatisticsRepository;
use Arbify\Http\Controllers\BaseController;
use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Contracts\Repositories\ProjectRepository;
use Arbify\Http\Requests\StoreProject;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Settings;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends BaseController
{
    private ProjectRepository $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;

        $this->middleware('verified');
        $this->authorizeResource(Project::class);
    }

    public function index(
        Request $request,
        MessagesTranslationStatisticsRepository $statisticsRepository
    ): View {
        $user = $request->user();

        if ($user->can('view-private', Project::class)) {
            $projects = $this->projectRepository->allPaginated($user);
        } else {
            $projects = $this->projectRepository->visibleToUserPaginated($user);
        }

        $statistics = [];
        foreach ($projects as $project) {
            $statistics[$project->id] = $statisticsRepository->byProject($project);
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

        return redirect()->route('messages.index', $project);
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
}
