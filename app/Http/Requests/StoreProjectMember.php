<?php

namespace App\Http\Requests;

use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectMember extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'role' => [
                'required',
                Rule::in(ProjectMember::RULES),
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['user_id'] = 'required|exists:' . User::class . ',id';
        }

        return $rules;
    }
}
