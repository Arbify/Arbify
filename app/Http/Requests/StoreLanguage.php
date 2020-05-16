<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'plural_forms' => 'required|array',
            'plural_forms.*' => [
                'required',
                Rule::in(array_keys(Language::PLURAL_FORMS)),
            ],
        ];
    }
}
