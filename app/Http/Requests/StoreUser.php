<?php

namespace App\Http\Requests;

use App\Models\User;
use Auth;
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
        $availableRoles = $this->getAvailableRoles($this->route('user'));

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
                !empty($availableRoles) ? 'required' : null,
                Rule::in($availableRoles),
            ]
        ];

        if ($this->isMethod('POST')) {
            $rules['email_verification'] = 'boolean';
            $rules['send_credentials'] = 'boolean';
        }

        return $rules;
    }

    private function getAvailableRoles(?User $editedUser): array
    {
        $roles = collect([
            User::ROLE_SUPER_ADMINISTRATOR,
            User::ROLE_ADMINISTRATOR,
            User::ROLE_USER,
            User::ROLE_GUEST,
        ]);

        return $roles->filter(function (int $role) use ($editedUser) {
            if ($editedUser) {
                return Auth::user()->can('update-role', [$editedUser, $role]);
            }

            return Auth::user()->can('create-role', [User::class, $role]);
        })->all();
    }
}
