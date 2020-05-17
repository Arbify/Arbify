<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Language;
use App\Models\Message;
use App\Models\MessageValue;
use App\Models\Project;
use Illuminate\Support\Collection;

interface MessageValueRepository
{
    public function byMessageLanguageAndForm(Message $message, Language $language, ?string $form): MessageValue;

    public function allByProject(Project $project): Collection;

    public function allByProjectAndLanguage(Project $project, Language $language): Collection;
}
