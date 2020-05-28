<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Contracts\Repositories\ProjectMemberRepository;
use Arbify\Contracts\Repositories\UserRepository;
use Arbify\Http\Controllers\Controller;
use Arbify\Http\Requests\StoreProjectMember;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProjectMemberController extends Controller
{
    private ProjectMemberRepository $projectMemberRepository;
    private UserRepository $userRepository;

    public function __construct(
        ProjectMemberRepository $projectMemberRepository,
        UserRepository $userRepository
    ) {
        $this->projectMemberRepository = $projectMemberRepository;
        $this->userRepository = $userRepository;

        $this->middleware('verified');
    }

    public function index(Project $project): View
    {
        $this->authorize('viewAny', [ProjectMember::class, $project]);

        $members = $this->projectMemberRepository->allInProject($project);

        return view('projects.members.index', [
            'project' => $project,
            'members' => $members,
        ]);
    }

    public function create(Project $project): View
    {
        $this->authorize('create', [ProjectMember::class, $project]);

        $users = $this->userRepository->allNotInProject($project);

        return view('projects.members.form', [
            'project' => $project,
            'users' => $users,
        ]);
    }

    public function store(StoreProjectMember $request, Project $project): Response
    {
        $this->authorize('create', [ProjectMember::class, $project]);

        $member = ProjectMember::create([
            'project_id' => $project->id
        ] + $request->validated());

        return redirect()->route('project-members.index', $project)
            ->with('success', "Added <b>{$member->user->name}</b> to this project successfully.");
    }

    public function edit(Project $project, ProjectMember $projectMember): View
    {
        $this->authorize('update', [$projectMember, $project]);

        $users = $this->userRepository->allNotInProject($project);

        return view('projects.members.form', [
            'project' => $project,
            'member' => $projectMember,
            'users' => $users,
        ]);
    }

    public function update(StoreProjectMember $request, Project $project, ProjectMember $projectMember): Response
    {
        $this->authorize('update', [$projectMember, $project]);

        $projectMember->update($request->validated());

        return redirect()->route('project-members.index', $project)
            ->with('success', "Updated <b>{$projectMember->user->name}</b> in this project successfully.");
    }

    public function destroy(Project $project, ProjectMember $projectMember): Response
    {
        $this->authorize('delete', [$projectMember, $project]);

        $projectMember->delete();

        return redirect()->route('project-members.index', $project)
            ->with('success', "Deleted <b>{$projectMember->user->name}</b> from this project successfully.");
    }
}
