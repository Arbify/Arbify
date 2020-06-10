<?php

declare(strict_types=1);

namespace Arbify\Repositories;

use Arbify\Contracts\Repositories\MessagesTranslationStatisticsRepository
    as MessagesTranslationStatisticsRepositoryContract;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\Project;

class MessagesTranslationStatisticsRepository implements
    MessagesTranslationStatisticsRepositoryContract
{
    private MessageValueRepository $messageValueRepository;

    public function __construct(MessageValueRepository $messageValueRepository)
    {
        $this->messageValueRepository = $messageValueRepository;
    }

    public function byProject(Project $project): array
    {
        $all = $project->messages->map(function (Message $message) use ($project) {
            return $project->languages->map(function (Language $language) use ($message) {
                if ($message->isPlural()) {
                    return count($language->plural_forms);
                } elseif ($message->isGender()) {
                    return count($language->gender_forms);
                } elseif ($message->isMessage()) {
                    return 1;
                }

                return 0;
            })->sum();
        })->sum();

        $translated = $this->messageValueRepository->latestCountByProject($project);

        return [
            'all' => $all,
            'translated' => $translated,
            'percent' => $this->makePercent($all, $translated),
        ];
    }

    public function byProjectAndLanguage(Project $project, Language $language): array
    {
        $all = $project->messages->map(function (Message $message) use ($language) {
            if ($message->isPlural()) {
                return count($language->plural_forms);
            } elseif ($message->isGender()) {
                return count($language->gender_forms);
            } elseif ($message->isMessage()) {
                return 1;
            }

            return 0;
        })->sum();

        $translated = $this->messageValueRepository->latestCountByProjectAndLanguage($project, $language);

        return [
            'all' => $all,
            'translated' => $translated,
            'percent' => $this->makePercent($all, $translated),
        ];
    }

    private function makePercent(int $all, int $translated): float
    {
        return round($translated / max($all, 1) * 100, 2);
    }
}
