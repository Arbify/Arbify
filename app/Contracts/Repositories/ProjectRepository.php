<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectRepository
{
    public function byId(int $id): Project;

    public function visibleToUserPaginated(User $user): LengthAwarePaginator;

    public function allPaginated(): LengthAwarePaginator;

    /**
     * Example return value:
     *
     *     [
     *         'all' => [
     *             'all' => 157,
     *             'translated' => 157,
     *             'percent' => 100,
     *         ],
     *        'en' => [
     *             'all' => 52,
     *             'translated' => 52,
     *             'percent' => 100,
     *         ],
     *         // more languages...
     *     ]
     *
     * @param Project $project
     *
     * @return array
     */
    public function translationStatistics(Project $project): array;
}
