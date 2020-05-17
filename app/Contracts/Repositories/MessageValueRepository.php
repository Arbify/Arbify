<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Language;
use App\Models\Project;
use Illuminate\Support\Collection;

interface MessageValueRepository
{
    public function byProject(Project $project): Collection;

    public function byProjectAndLanguage(Project $project, Language $language): Collection;
}
