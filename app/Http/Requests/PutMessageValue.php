<?php

namespace Arbify\Http\Requests;

use Arbify\Models\Language;
use Illuminate\Validation\Rule;

class PutMessageValue extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'message_value' => 'nullable',
        ];
    }
}
