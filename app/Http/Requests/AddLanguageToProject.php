<?php

namespace App\Http\Requests;

use App\Models\Language;

class AddLanguageToProject extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'language' => 'required|exists:' . Language::class . ',id',
        ];
    }
}
