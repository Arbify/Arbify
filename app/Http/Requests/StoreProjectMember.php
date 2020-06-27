<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Language;
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
            'allowed_languages' => [
                'exclude_unless:role,' . ProjectMember::ROLE_TRANSLATOR,
                'required',
                'array',
            ],
            'allowed_languages.*' => [
                'required',
                'exists:' . Language::class . ',id',
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['user_id'] = 'required|exists:' . User::class . ',id';
        }

        return $rules;
    }
}
