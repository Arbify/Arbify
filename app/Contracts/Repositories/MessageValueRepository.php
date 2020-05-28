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
    public function byMessageLanguageAndFormOrCreate(Message $message, Language $language, ?string $form): MessageValue;

    /**
     * Returns an associative array with message values grouped by message id and language id.
     *
     *     [
     *         1 => [ // 1 is message id
     *             13 => [ // 13 is language id
     *                 '' => [ // '' (null) is message form
     *                     // Only relation ids, `name` and `value` keys are available.
     *                     'name' => 'app_name',
     *                     'value' => 'Example app'
     *                 ],
     *                 // (...)
     *             ],
     *             // (...)
     *         ],
     *         // (...)
     *     ]
     *
     * @param Project $project
     *
     * @return array
     */
    public function allByProjectAssociativeGrouped(Project $project): array;

    public function allByProjectAndLanguage(Project $project, Language $language): Collection;

    /**
     * Returns an associative array with project languages as keys and last updated_at date as value.
     *
     *     [
     *         "pl": "2020-05-28 12:22:27",
     *         "az": "2020-05-28 13:25:59",
     *         "iu": null,
     *         // (...)
     *     ]
     *
     * @param Project $project
     *
     * @return array
     */
    public function languageGroupedDetailsByProject(Project $project): array;
}
