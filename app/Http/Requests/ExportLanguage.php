<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Language;

class ExportLanguage extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'language' => 'required|exists:' . Language::class . ',id'
        ];
    }
}
