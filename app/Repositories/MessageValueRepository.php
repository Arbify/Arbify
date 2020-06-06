<?php

declare(strict_types=1);

namespace Arbify\Repositories;

use Arbify\Contracts\Repositories\MessageValueRepository as MessageValueRepositoryContract;
use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use Arr;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;

class MessageValueRepository implements MessageValueRepositoryContract
{
    public function latest(Message $message, Language $language, ?string $form): ?MessageValue
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $message->messageValues()
            ->where('language_id', $language->id)
            ->where('form', $form)
            ->orderByDesc('message_values.updated_at')
            ->first();
    }

    public function history(Message $message, Language $language, ?string $form): Collection
    {
        return $message->messageValues()
            ->where('language_id', $language->id)
            ->where('form', $form)
            ->orderByDesc('message_values.updated_at')
            ->get();
    }

    public function allByProjectAssociativeGrouped(Project $project): array
    {
        // FIXME: Return only the latest ones.
        // https://stackoverflow.com/questions/1313120/retrieving-the-last-record-in-each-group-mysql
        $values = $project->messageValues()
            ->orderByDesc('message_values.updated_at')
            ->get([
                'message_id',
                'language_id',
                'form',
                'name',
                'value',
            ])
            ->toArray();

        $results = [];
        foreach ($values as $value) {
            $results[$value['message_id']][$value['language_id']][$value['form']] = $value;
        }

        return $results;
    }

    public function allByProjectAndLanguage(Project $project, Language $language): Collection
    {
        // FIXME: Return only the latest ones.
        return $project->messageValues()
            ->where('language_id', $language->id)
            ->orderByDesc('message_values.updated_at')
            ->get();
    }

    public function languageGroupedDetailsByProject(Project $project): array
    {
        // FIXME: Maybe replace this with a query without the n+1 problem.
        // FIXME: Return only the latest ones.
        $result = $project->languages
            ->map(function (Language $language) use ($project) {
                /** @var string $lastModified */
                $lastModified = $project->messageValues()
                    ->where('language_id', $language->id)
                    ->orderByDesc('message_values.updated_at')
                    ->max('message_values.updated_at');

                $lastModifiedIso8601 = $lastModified ? Carbon::parse($lastModified)->toIso8601String() : null;

                return [$language->code => $lastModifiedIso8601];
            });

        return Arr::collapse($result);
    }
}
