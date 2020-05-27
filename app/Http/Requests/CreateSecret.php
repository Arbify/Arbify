<?php

namespace App\Http\Requests;

class CreateSecret extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
