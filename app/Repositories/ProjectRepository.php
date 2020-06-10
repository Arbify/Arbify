<?php

declare(strict_types=1);

namespace Arbify\Repositories;

use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Contracts\Repositories\ProjectRepository as ProjectRepositoryContract;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Arbify\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;

class ProjectRepository implements ProjectRepositoryContract
{
    private MessageValueRepository $messageValueRepository;

    public function __construct(MessageValueRepository $messageValueRepository)
    {
        $this->messageValueRepository = $messageValueRepository;
    }

    public function byId(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function visibleToUserPaginated(User $user): LengthAwarePaginator
    {
        return Project::query()
            ->where('visibility', '=', Project::VISIBILITY_PUBLIC)
            ->orWhereExists(function (Builder $builder) use ($user) {
                $builder
                    ->from('projects')
                    ->join('project_members', 'project_members.project_id', '=', 'projects.id')
                    ->where('project_members.user_id', '=', $user->id);
            })
            ->orderBy('name')
            ->paginate(30);
    }

    public function allPaginated(): LengthAwarePaginator
    {
        return Project::orderBy('name')->paginate(30);
    }
}
