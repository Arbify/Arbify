<?php

use Arbify\Models\User;
use Symfony\Component\HttpFoundation\Response;

/**
 * @param int $status
 * @param null $content
 * @param array $headers
 *
 * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
 */
function status(int $status, $content = null, array $headers = []): Response
{
    return response($content, $status, $headers);
}

function canGiveRole(?User $model, int $role): bool
{
    if ($model) {
        return Auth::user()->can('update-role', [$model, $role]);
    }

    return Auth::user()->can('create-role', [User::class, $role]);
}
