<?php

namespace Arbify\Http\Resources;

use Arbify\Models\Message as MessageModel;
use Arbify\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    public function toArray($request): array
    {
        /** @var $message MessageModel */
        $message = $this->resource;
        /** @var User $user */
        $user = $request->user();

        return [
            'id' => $message->id,
            'name' => $message->name,
            'description' => $message->description,
            'type' => $message->type,
            'project_id' => $message->project_id,
            'can_update' => $user->can('update', [$message, $request->route('project')]),
            'can_delete' => $user->can('delete', [$message, $request->route('project')]),
        ];
    }
}
