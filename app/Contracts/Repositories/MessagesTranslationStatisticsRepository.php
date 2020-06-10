<?php

declare(strict_types=1);

namespace Arbify\Contracts\Repositories;

use Arbify\Models\Language;
use Arbify\Models\Project;

interface MessagesTranslationStatisticsRepository
{
    public function byProject(Project $project): array;

    public function byProjectAndLanguage(Project $project, Language $language): array;
}
