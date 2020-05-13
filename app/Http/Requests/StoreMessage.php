<?php

namespace App\Http\Requests;

use App\Message;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMessage extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                $this->isMethod('PATCH')
                    ? 'unique:' . Message::class . ',id,' . $this->route('message')->id
                    : 'unique:' . Message::class,
            ],
            'description' => '',
        ];

        if ($this->isMethod('POST')) {
            $rules['type'] = [
                'required',
                Rule::in([
                    Message::TYPE_MESSAGE,
                    Message::TYPE_PLURAL,
                    Message::TYPE_GENDER,
                ]),

            ];
        }

        return $rules;
    }
}
