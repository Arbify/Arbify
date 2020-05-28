<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Language;
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
