<?php

declare(strict_types=1);

namespace Arbify\Repositories;

use Arbify\Contracts\Repositories\MessageRepository as MessageRepositoryContract;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Illuminate\Support\Collection;

class MessageRepository implements MessageRepositoryContract
{
    public function byId(int $id): Message
    {
        return Message::findOrFail($id);
    }

    public function byProject(Project $project): Collection
    {
        return $project
            ->messages()
            ->orderBy('created_at')
            ->get();
    }

    public function isNameUniqueInProject(string $name, Project $project, ?Message $except = null): bool
    {
        return $project->messages->every(function (Message $message, $key) use ($name, $except) {
            if ($except && $message->id == $except->id) {
                return true;
            }

            return $message->name != $name;
        });
    }
}
