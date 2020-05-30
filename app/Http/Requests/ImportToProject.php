<?php

namespace Arbify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportToProject extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required',
            'override_message_values' => 'boolean',
        ];
    }
}
