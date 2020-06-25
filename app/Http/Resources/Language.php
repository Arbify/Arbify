<?php

namespace Arbify\Http\Resources;

use Arbify\Models\Language as LanguageModel;
use Illuminate\Http\Resources\Json\JsonResource;

class Language extends JsonResource
{
    public function toArray($request): array
    {
        /** @var $language LanguageModel */
        $language = $this->resource;

        return [
            'id' => $language->id,
            'name' => $language->name,
            'code' => $language->code,
            'display_name' => $language->getDisplayName(),
            'flag_url' => $language->flag === null ? null : asset("images/flags/{$language->flag}.svg"),
            'plural_forms' => $language->plural_forms,
            'gender_forms' => $language->gender_forms,
        ];
    }
}
