<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectRole;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProjectRoleController extends Controller
{
    public function index(Project $project): View
    {
        return view('projects.roles.index', [
            'project' => $project,
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

    public function edit(ProjectRole $projectRole): View
    {
        //
    }

    public function update(Request $request, ProjectRole $projectRole): Response
    {
        //
    }

    public function destroy(ProjectRole $projectRole): Response
    {
        //
    }
}
