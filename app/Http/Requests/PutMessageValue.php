<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Validation\Rule;

class PutMessageValue extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'value' => 'nullable',
            'form' => [
                'sometimes',
                Rule::in(array_merge(
                    array_keys(Language::PLURAL_FORMS),
                    Language::GENDER_FORMS
                )),
            ]
        ];
    }
}
