<?php

namespace Arbify\Security\Policies;

use Arbify\Contracts\Repositories\ProjectMemberRepository;
use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Arbify\Models\User;

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

    public function putLanguage(
        User $user,
        Project $project,
        Language $language
    ): bool {
        // fixme(Albert221): I don't like this code, maybe I'll fix it sometime.
        if ($this->isLeadOrMemberInProject($user, $project)) {
            return true;
        }

        if (!$this->isInProject($user, $project)) {
            return false;
        }

        return $this->cachedMemberByUserAndProject($user, $project)->allowedLanguages()->get()->contains($language);
    }
}
