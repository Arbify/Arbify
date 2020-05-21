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

        return $this->isInProject($user, $project);
    }

    private function isLeadInProject(User $user, Project $project): bool
    {
        $member = $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);

        return $member !== null && $member->isLead();
    }

    private function isLeadOrMemberInProject(User $user, Project $project): bool
    {
        $member = $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);

        return $member !== null && ($member->isLead() || $member->isMember());
    }

    private function isInProject(User $user, Project $project): bool
    {
        return null !== $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);
    }
}
