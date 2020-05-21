<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Project;
use App\Models\ProjectRole;
use App\Models\User;

interface ProjectRoleRepository
{
    public function byProjectAndUserOrNull(Project $project, User $user): ?ProjectRole;
}
