<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\MessageValueRepository as MessageValueRepositoryContract;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Support\Collection;

class MessageValueRepository implements MessageValueRepositoryContract
{
    public function byProject(Project $project): Collection
    {
        return $project->messageValues()->get();
    }

    public function byProjectAndLanguage(Project $project, Language $language): Collection
    {
        return $project->messageValues()->getQuery()
            ->where('language_id', $language->id)
            ->get();
    }
}
