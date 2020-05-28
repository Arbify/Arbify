<?php

namespace Arbify\Http\Requests;

class UpdatePassword extends AuthorizedFormRequest
{
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ];
    }
}
