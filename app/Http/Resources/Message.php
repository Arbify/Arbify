<?php

namespace Arbify\Http\Resources;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    public function toArray($request): array
    {
        /** @var $request Request */
        /** @var $message \Arbify\Models\Message */
        $message = $this->resource;

        return [
            'id' => $message->id,
            'name' => $message->name,
            'description' => $message->description,
            'type' => $message->type,
            'project_id' => $message->project_id,
            'can_update' => Gate::allows('update', [$message, $request->route('project')]),
            'can_delete' => Gate::allows('delete', [$message, $request->route('project')]),
        ];
    }
}
