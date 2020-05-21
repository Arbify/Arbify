<?php

namespace App\Policies;

use App\Contracts\Repositories\ProjectMemberRepository;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;

class MessagePolicy extends BasePolicy
{
    use Helpers\ProjectMemberChecks;

    public function __construct(ProjectMemberRepository $projectMemberRepository)
    {
        $this->projectMemberRepository = $projectMemberRepository;
    }

    public function before(User $user, $ability): ?bool
    {
        if ($this->hasAdministrativeRights($user)) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user, Project $project): bool
    {
        return $this->canViewProject($user, $project);
    }

    public function create(User $user, Project $project): bool
    {
        return $this->isLeadOrMemberInProject($user, $project);
    }

    public function update(User $user, Message $message, Project $project): bool
    {
        return $this->isLeadOrMemberInProject($user, $project);
    }

    public function delete(User $user, Message $message, Project $project): bool
    {
        return $this->isLeadOrMemberInProject($user, $project);
    }
}
