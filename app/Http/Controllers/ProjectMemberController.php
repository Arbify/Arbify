<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ProjectMemberRepository;
use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProjectMemberController extends Controller
{
    private ProjectMemberRepository $projectMemberRepository;

    public function __construct(ProjectMemberRepository $projectMemberRepository)
    {
        $this->projectMemberRepository = $projectMemberRepository;

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
    }

    public function store(Request $request, Project $project): Response
    {
        $this->authorize('create', [ProjectMember::class, $project]);
    }

    public function edit(Project $project, ProjectMember $projectMember): View
    {
        $this->authorize('update', [ProjectMember::class, $project]);
    }

    public function update(Request $request, Project $project, ProjectMember $projectMember): Response
    {
        $this->authorize('update', [ProjectMember::class, $project]);
    }

    public function destroy(Project $project, ProjectMember $projectMember): Response
    {
        $this->authorize('delete', [ProjectMember::class, $project]);
    }
}
