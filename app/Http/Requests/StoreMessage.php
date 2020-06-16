<?php

namespace Arbify\Http\Requests;

use Arbify\Contracts\Repositories\MessageRepository;
use Arbify\Models\Message;
use Illuminate\Validation\Rule;

class StoreMessage extends AuthorizedFormRequest
{
    private const NAME_REGEX = '/^[a-z][a-z0-9_]*$/i';

    public function rules(MessageRepository $messageRepository): array
    {
        $rules = [
            'name' => [
                'required',
                'regex:' . self::NAME_REGEX,
                $this->makeNameUniqueInProjectValidator($messageRepository),
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

    public function messages(): array
    {
        return [
            'name.regex' => 'The :attribute should only begin with a letter '
                . 'followed by alphanumeric characters or underscores '
                . '(pattern: <code>' . self::NAME_REGEX . '</code>).',
        ];
    }

    private function makeNameUniqueInProjectValidator(MessageRepository $messageRepository): callable
    {
        return function ($attribute, $value, $fail) use ($messageRepository) {
            if (
                false === $messageRepository->isNameUniqueInProject(
                    $value,
                    $this->route('project'),
                    $this->isMethod('PATCH') ? $this->route('message') : null,
                )
            ) {
                $fail("This name is already used in this project.");
            }
        };
    }
}
