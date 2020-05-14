<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
        ];
    }
}
