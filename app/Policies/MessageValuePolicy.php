<?php

namespace App\Policies;

use App\Contracts\Repositories\ProjectMemberRepository;
use App\Models\Language;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;

class MessageValuePolicy extends BasePolicy
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

    public function put(
        User $user,
        Project $project,
        Message $message,
        Language $language
    ): bool {
        if ($this->isLeadOrMemberInProject($user, $project)) {
            return true;
        }

        // TODO: Check user's membership for `extra` if translator is only for given language.
        return $this->isInProject($user, $project);
    }
}
