<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Support\Collection;

interface ProjectMemberRepository
{
    public function byId(int $id): ProjectMember;

    public function allInProject(Project $project): Collection;

    public function byProjectAndUserOrNull(Project $project, User $user): ?ProjectMember;
}
