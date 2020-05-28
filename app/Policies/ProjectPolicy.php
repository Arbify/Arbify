<?php

namespace Arbify\Policies;

use Arbify\Contracts\Repositories\ProjectMemberRepository;
use Arbify\Models\Project;
use Arbify\Models\User;

class ProjectPolicy extends BasePolicy
{
    use Helpers\ProjectMemberChecks;

    public function __construct(ProjectMemberRepository $projectMemberRepository)
    {
        $this->projectMemberRepository = $projectMemberRepository;
    }

    public function before(User $user, $ability): ?bool
    {
        if ($this->hasAdministrativeRights($user)) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function viewPrivate(User $user): bool
    {
        return $this->hasAdministrativeRights($user);
    }

    public function view(User $user, Project $project): bool
    {
        return $this->canViewProject($user, $project);
    }

    public function create(User $user): bool
    {
        return $this->hasAdministrativeRights($user);
    }

    public function update(User $user, Project $project): bool
    {
        return $this->isLeadInProject($user, $project);
    }

    public function manageLanguages(User $user, Project $project): bool
    {
        return $this->isLeadInProject($user, $project);
    }

    public function delete(User $user, Project $project): bool
    {
        return $this->isLeadInProject($user, $project);
    }
}
