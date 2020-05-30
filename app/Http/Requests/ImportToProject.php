<?php

namespace Arbify\Http\Requests;

use Albert221\Filepond\FilepondRule;
use Albert221\Filepond\FilepondSerializer;

class ImportToProject extends AuthorizedFormRequest
{
    public function rules(FilepondSerializer $filepondSerializer): array
    {
        return [
            'file.*' => [
                'required',
                new FilepondRule($filepondSerializer, [
                    'mimetypes:application/pdf',
                ]),
            ],
            'override_message_values' => 'boolean',
        ];
    }
}
