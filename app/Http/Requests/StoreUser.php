<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                $this->isMethod('PATCH')
                    ? 'unique:' . User::class . ',id,' . $this->route('user')->id
                    : 'unique:' . User::class,
            ],
            'password' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'min:8',
            ],
            'role' => [
                'required',
                Rule::in([
                    // Only Super administrators can make other users super administrators.
                    $this->user()->isSuperAdministrator() ? User::ROLE_SUPER_ADMINISTRATOR : null,
                    User::ROLE_ADMINISTRATOR,
                    User::ROLE_USER,
                    User::ROLE_GUEST,
                ]),
            ]
        ];

        if ($this->isMethod('POST')) {
            $rules['email_verification'] = 'boolean';
            $rules['send_credentials'] = 'boolean';
        }

        return $rules;
    }
}
