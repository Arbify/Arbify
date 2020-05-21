<?php

namespace App\Policies;

use App\Contracts\Repositories\ProjectRoleRepository;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy extends BasePolicy
{
    private ProjectRoleRepository $projectRoleRepository;

    public function __construct(ProjectRoleRepository $projectRoleRepository)
    {
        $this->projectRoleRepository = $projectRoleRepository;
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

    public function viewOnlyForMembers(User $user): bool
    {
        return $this->hasAdministrativeRights($user);
    }

    public function view(User $user, Project $project): bool
    {
        if ($project->isPublic()) {
            return true;
        }

        return null !== $this->projectRoleRepository->byProjectAndUserOrNull($project, $user);
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

    private function isLeadInProject(User $user, Project $project): bool
    {
        $role = $this->projectRoleRepository->byProjectAndUserOrNull($project, $user);

        return $role !== null && $role->isLead();
    }
}
