<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\MessageRepository as MessageRepositoryContract;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Support\Collection;

class MessageRepository implements MessageRepositoryContract
{
    public function byId(int $id): Message
    {
        return Message::findOrFail($id);
    }

    public function byProject(Project $project): Collection
    {
        return $project->messages()->get();
    }
}
