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
    }

    public function index(Project $project): View
    {
        $members = $this->projectMemberRepository->allInProject($project);

        return view('projects.members.index', [
            'project' => $project,
            'members' => $members,
        ]);
    }

    public function create(): View
    {
        //
    }

    public function store(Request $request): Response
    {
        //
    }

    public function edit(ProjectMember $projectMember): View
    {
        //
    }

    public function update(Request $request, ProjectMember $projectMember): Response
    {
        //
    }

    public function destroy(ProjectMember $projectMember): Response
    {
        //
    }
}
