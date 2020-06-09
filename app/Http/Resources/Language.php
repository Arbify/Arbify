<?php

namespace Arbify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Language extends JsonResource
{
    public function toArray($request): array
    {
        /** @var $language \Arbify\Models\Language */
        $language = $this->resource;

        return [
            'id' => $language->id,
            'name' => $language->name,
            'code' => $language->code,
            'display_name' => $language->getDisplayName(),
            'flag_url' => asset("storage/flags/{$language->flag}.svg"),
            'plural_forms' => $language->plural_forms,
            'gender_forms' => $language->gender_forms,
        ];
    }
}
