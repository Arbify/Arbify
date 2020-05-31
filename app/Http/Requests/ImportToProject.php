<?php

namespace Arbify\Http\Requests;

use Albert221\Filepond\FilepondRule;
use Albert221\Filepond\FilepondSerializer;

class ImportToProject extends AuthorizedFormRequest
{
    public function rules(FilepondSerializer $filepondSerializer): array
    {
        return [
            'files.*' => [
                'required',
                new FilepondRule($filepondSerializer),
            ],
            'override_message_values' => 'boolean',
        ];
    }
}
