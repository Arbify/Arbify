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
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
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
        return $this->countMessagesBy([
            'project_id' => $project->id,
            'language_id' => $language->id,
        ]);
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
        $values = $this->latestMessagesBy(['project_id' => $project->id]);

        $results = [];
        foreach ($values as $value) {
            $results[$value['message_id']][$value['language_id']][$value['form']] = $value;
        }

        return $results;
    }

    public function allByProjectAndLanguage(Project $project, Language $language): Collection
    {
        return $this->latestMessagesBy([
            'project_id' => $project->id,
            'language_id' => $language->id,
        ]);
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

    private function latestMessagesBy(array $conditions = []): EloquentCollection
    {
        $innerQuery = $this->buildInnerLatestMessagesQuery($conditions);

        $values = collect(DB::select(DB::raw(
            "WITH latest_message_values AS ($innerQuery)
            SELECT * FROM latest_message_values WHERE updated_at = last_updated"
        ), array_values($conditions)));

        return MessageValue::hydrate($values->toArray());
    }

    private function countMessagesBy(array $conditions = []): int
    {
        $innerQuery = $this->buildInnerLatestMessagesQuery($conditions);

        return (int) DB::selectOne(DB::raw(
            "WITH latest_message_values AS ($innerQuery)
            SELECT COUNT(id) AS count FROM latest_message_values WHERE updated_at = last_updated"
        ), array_values($conditions))->count;
    }

    private function buildInnerLatestMessagesQuery(array $conditions): string
    {
        $where = collect($conditions)->keys()->map(fn(string $key) => "$key = ?")->implode(' AND ');
        $where = !empty($where) ? "WHERE $where" : '';

        // https://stackoverflow.com/questions/1313120/retrieving-the-last-record-in-each-group-mysql
        return "SELECT mv.*, MAX(mv.updated_at) OVER(PARTITION BY message_id, language_id, form) AS last_updated
            FROM message_values AS mv
            INNER JOIN messages on messages.id = mv.message_id
            $where";
    }
}
