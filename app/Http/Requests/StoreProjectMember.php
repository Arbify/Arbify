<?php

namespace App\Http\Requests;

use App\Models\ProjectMember;
use App\Models\User;
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
