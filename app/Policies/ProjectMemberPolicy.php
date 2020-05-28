<?php

namespace Arbify\Policies;

use Arbify\Contracts\Repositories\ProjectMemberRepository;
use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Arbify\Models\User;

class ProjectMemberPolicy extends BasePolicy
{
    use Helpers\ProjectMemberChecks;

    public function __construct(ProjectMemberRepository $projectMemberRepository)
    {
        $this->projectMemberRepository = $projectMemberRepository;
    }

    public function before(User $user, $ability): ?bool
    {
        if (in_array($ability, ['update', 'delete'])) {
            return null;
        }

        if ($this->hasAdministrativeRights($user)) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user, Project $project): bool
    {
        return $this->canViewProject($user, $project) && !$user->isGuest();
    }

    public function create(User $user, Project $project): bool
    {
        return $this->isLeadInProject($user, $project);
    }

    public function update(User $user, ProjectMember $projectMember, Project $project): bool
    {
        // You can't change your role in the project.
        if ($projectMember->user->id === $user->id) {
            return false;
        }

        return $this->isLeadInProject($user, $project) || $this->hasAdministrativeRights($user);
    }

    public function delete(User $user, ProjectMember $projectMember, Project $project): bool
    {
        // You can't remove yourself from the project.
        if ($projectMember->user->id === $user->id) {
            return false;
        }

        return $this->isLeadInProject($user, $project) || $this->hasAdministrativeRights($user);
    }
}
