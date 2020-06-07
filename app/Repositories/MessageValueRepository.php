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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
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

    public function latestCountByProjectAndLanguage(Project $project, Language $language): int
    {
        return $this->latestMessagesFrom($project)
            ->where('mv.language_id', $language->id)
            ->count();
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
        $values = $this->latestMessagesFrom($project)->get()->toArray();

        $results = [];
        foreach ($values as $value) {
            $results[$value['message_id']][$value['language_id']][$value['form']] = $value;
        }

        return $results;
    }

    public function allByProjectAndLanguage(Project $project, Language $language): Collection
    {
        return $this->latestMessagesFrom($project)
            ->where('mv.language_id', $language->id)
            ->get();
    }

    public function languageGroupedDetailsByProject(Project $project): array
    {
        // FIXME: Maybe replace this with a query without the n+1 problem.
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

    private function latestMessagesFrom(Project $project): Builder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return MessageValue::from('message_values AS mv')
            ->select('mv.*')
            ->join('messages', 'messages.id', '=', 'mv.message_id')
            ->leftJoin('message_values AS mv2', function (JoinClause $query) {
                $query
                    ->on('mv.message_id', '=', 'mv2.message_id')
                    ->on('mv.language_id', '=', 'mv2.language_id')
                    ->on(function (JoinClause $query) {
                        $query->whereRaw('mv.form = mv2.form OR mv.form IS NULL AND mv2.form IS NULL');
                    })
                    ->on('mv.updated_at', '<', 'mv2.updated_at');
            })
            ->where('messages.project_id', $project->id)
            ->whereNull('mv2.id');
    }
}
