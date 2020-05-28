<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Language;

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
