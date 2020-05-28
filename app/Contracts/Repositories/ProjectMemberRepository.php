<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

use Arbify\Models\Project;
use Arbify\Models\ProjectMember;
use Arbify\Models\User;
use Illuminate\Support\Collection;

interface ProjectMemberRepository
{
    public function byId(int $id): ProjectMember;

    public function allInProject(Project $project): Collection;

    public function byProjectAndUserOrNull(Project $project, User $user): ?ProjectMember;
}
