<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Project;
use Illuminate\Validation\Rule;

class StoreProject extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'visibility' => [
                'required',
                Rule::in([Project::VISIBILITY_PUBLIC, Project::VISIBILITY_PRIVATE]),
            ],
        ];
    }
}
