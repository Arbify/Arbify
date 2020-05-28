<?php

namespace Arbify\Http\Requests;

use Arbify\Models\ProjectMember;
use Arbify\Models\User;
use Illuminate\Validation\Rule;

class StoreProjectMember extends AuthorizedFormRequest
{
    public function rules(): array
    {
        $rules = [
            'role' => [
                'required',
                Rule::in(ProjectMember::ROLES),
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['user_id'] = 'required|exists:' . User::class . ',id';
        }

        return $rules;
    }
}
