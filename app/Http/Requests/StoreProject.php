<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProject extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
