<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Language;

class AddLanguagesToProject extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'languages' => 'required|array',
            'languages.*' => 'required|exists:' . Language::class . ',id',
        ];
    }
}
