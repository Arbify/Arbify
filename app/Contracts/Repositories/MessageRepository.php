<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

use Arbify\Models\Message;
use Arbify\Models\Project;
use Illuminate\Support\Collection;

interface MessageRepository
{
    public function byId(int $id): Message;

    public function byProject(Project $project): Collection;

    public function isNameUniqueInProject(string $name, Project $project, ?Message $except = null): bool;
}
