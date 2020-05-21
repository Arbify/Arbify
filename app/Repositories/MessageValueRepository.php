<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\MessageValueRepository as MessageValueRepositoryContract;
use App\Models\Language;
use App\Models\Message;
use App\Models\MessageValue;
use App\Models\Project;
use Illuminate\Support\Collection;

class MessageValueRepository implements MessageValueRepositoryContract
{
    public function byMessageLanguageAndForm(Message $message, Language $language, ?string $form): MessageValue
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $message->messageValues()
            ->where('language_id', $language->id)
            ->where('form', $form)
            ->firstOrCreate([
                'language_id' => $language->id,
                'form' => $form,
            ]);
    }

    public function allByProject(Project $project): Collection
    {
        return $project->messageValues()->get();
    }

    public function allByProjectAndLanguage(Project $project, Language $language): Collection
    {
        return $project->messageValues()
            ->where('language_id', $language->id)
            ->get();
    }
}
