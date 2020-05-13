<?php

namespace App\Http\Requests;

use App\Language;
use Illuminate\Foundation\Http\FormRequest;

class StoreLanguage extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                $this->isMethod('PATCH')
                    ? 'unique:' . Language::class . ',id,' . $this->route('language')->id
                    : 'unique:' . Language::class,
            ],
            'name' => '',
            'flag' => '',
        ];
    }
}
