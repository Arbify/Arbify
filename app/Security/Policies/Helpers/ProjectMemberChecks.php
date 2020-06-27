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
        if ($project->isPublic() && !$user->isGuest()) {
            return true;
        }

        return $this->isInProject($user, $project);
    }

    private function isLeadInProject(User $user, Project $project): bool
    {
        $member = $this->cachedMemberByUserAndProject($user, $project);

        return $member !== null && $member->isLead();
    }

    private function isLeadOrMemberInProject(User $user, Project $project): bool
    {
        $member = $this->cachedMemberByUserAndProject($user, $project);

        return $member !== null && ($member->isLead() || $member->isMember());
    }

    private function cachedMemberByUserAndProject(User $user, Project $project): ?ProjectMember
    {
        $cacheKey = sprintf('projectMember.%s.%s', $user->id, $project->id);

        return Cache::remember($cacheKey, now()->addSecond(), function () use ($user, $project) {
            return $this->inProject($user, $project);
        });
    }

    private function inProject(User $user, Project $project): ?ProjectMember
    {
        return $this->projectMemberRepository->byProjectAndUserOrNull($project, $user);
    }

    private function isInProject(User $user, Project $project): bool
    {
        return null !== $this->cachedMemberByUserAndProject($user, $project);
    }
}
