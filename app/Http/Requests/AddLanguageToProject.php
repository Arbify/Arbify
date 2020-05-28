<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Language;

class AddLanguageToProject extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'language' => 'required|exists:' . Language::class . ',id',
        ];
    }
}
