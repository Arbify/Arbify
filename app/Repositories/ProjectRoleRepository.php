<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProjectRoleRepository as ProjectRoleRepositoryContract;
use App\Models\Project;
use App\Models\ProjectRole;
use App\Models\User;

class ProjectRoleRepository implements ProjectRoleRepositoryContract
{
    public function byProjectAndUserOrNull(Project $project, User $user): ?ProjectRole
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $project->projectRoles()->firstWhere('user_id', $user->id);
    }
}
