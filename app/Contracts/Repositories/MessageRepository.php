<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Message;
use App\Models\Project;
use Illuminate\Support\Collection;

interface MessageRepository
{
    public function byId(int $id): Message;

    public function byProject(Project $project): Collection;
}
