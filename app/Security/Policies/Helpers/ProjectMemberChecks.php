<?php

declare(strict_types=1);

namespace Arbify\Security\Policies\Helpers;

use Arbify\Contracts\Repositories\ProjectMemberRepository;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Arbify\Models\User;
use Cache;

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
        $member = $this->cachedMemberByProjectAndUser($user, $project);

        return $member !== null && $member->isLead();
    }

    private function isLeadOrMemberInProject(User $user, Project $project): bool
    {
        $member = $this->cachedMemberByProjectAndUser($user, $project);

        return $member !== null && ($member->isLead() || $member->isMember());
    }

    private function cachedMemberByProjectAndUser(User $user, Project $project): ?ProjectMember
    {
        $cacheKey = sprintf('isLeadOrMemberInProject.%s.%s', $user->id, $project->id);

        return Cache::remember($cacheKey, now()->addSecond(), function () use ($project, $user) {
            return $member = $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);
        });
    }

    private function isInProject(User $user, Project $project): bool
    {
        return null !== $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);
    }
}
