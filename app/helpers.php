<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

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
