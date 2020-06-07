<?php

declare(strict_types=1);

namespace Arbify\Repositories;

use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Contracts\Repositories\ProjectRepository as ProjectRepositoryContract;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Arbify\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;

class ProjectRepository implements ProjectRepositoryContract
{
    private MessageValueRepository $messageValueRepository;

    public function __construct(MessageValueRepository $messageValueRepository)
    {
        $this->messageValueRepository = $messageValueRepository;
    }

    public function byId(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function visibleToUserPaginated(User $user): LengthAwarePaginator
    {
        return Project::query()
            ->where('visibility', '=', Project::VISIBILITY_PUBLIC)
            ->orWhereExists(function (Builder $builder) use ($user) {
                $builder
                    ->from('projects')
                    ->join('project_members', 'project_members.project_id', '=', 'projects.id')
                    ->where('project_members.user_id', '=', $user->id);
            })
            ->orderBy('name')
            ->paginate(30);
    }

    public function allPaginated(): LengthAwarePaginator
    {
        return Project::orderBy('name')->paginate(30);
    }

    public function translationStatistics(Project $project): array
    {
        // TODO: Utilize caching.

        $statistics = [
            'all' => [
                'all' => 0,
                'translated' => 0
            ],
        ];

        $messages = $project->messages;
        $messageValues = $project->messageValues;

        foreach ($project->languages as $language) {
            $allValues = $messages
                ->map(function (Message $message) use ($language) {
                    if ($message->isPlural()) {
                        return count($language->plural_forms);
                    } elseif ($message->isGender()) {
                        return count($language->getGenderForms());
                    }

                    return 1;
                })
                ->sum();

            // FIXME: n+1 problem here
            $translatedValues = $this->messageValueRepository->latestCountByProjectAndLanguage($project, $language);

            $statistics['all']['all'] += $allValues;
            $statistics['all']['translated'] += $translatedValues;

            $statistics[$language->code] = [
                'all' => $allValues,
                'translated' => $translatedValues,
                'percent' => round($translatedValues / max($allValues, 1) * 100, 2),
            ];
        }

        $statistics['all']['percent'] = round(
            $statistics['all']['translated'] / max($statistics['all']['all'], 1) * 100,
            2
        );

        return $statistics;
    }
}
