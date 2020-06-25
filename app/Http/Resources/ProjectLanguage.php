<?php

declare(strict_types=1);

namespace Arbify\Http\Resources;

use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use Arbify\Models\User;

class ProjectLanguage extends Language
{
    public function toArray($request): array
    {
        $languageOutput = parent::toArray($request);

        /** @var $language Language */
        $language = $this->resource;
        /** @var User $user */
        $user = $request->user();
        /** @var Project $project */
        $project = $request->route('project');

        return array_merge($languageOutput, [
            'can_put_values' => $user->can('putLanguage', [MessageValue::class, $project, $language]),
        ]);
    }
}
