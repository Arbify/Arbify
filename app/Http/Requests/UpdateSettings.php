<?php

namespace App\Http\Requests;

use App\Models\Language;

class UpdateSettings extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'registration_enabled' => 'required|boolean',
            'default_language' => 'required|exists:' . Language::class . ',id',
        ];
    }
}
