<?php

declare(strict_types=1);

namespace App\Policies\Helpers;

use App\Contracts\Repositories\ProjectMemberRepository;
use App\Models\Project;
use App\Models\User;

trait ProjectMemberChecks
{
    public ProjectMemberRepository $projectMemberRepository;

    protected function canViewProject(User $user, Project $project): bool
    {
        if ($project->isPublic()) {
            return true;
        }

        return null !== $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);
    }

    private function isLeadInProject(User $user, Project $project): bool
    {
        $role = $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);

        return $role !== null && $role->isLead();
    }
}
