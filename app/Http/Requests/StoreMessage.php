<?php

namespace Arbify\Http\Requests;

use Arbify\Contracts\Repositories\MessageRepository;
use Arbify\Models\Message;
use Illuminate\Validation\Rule;

class StoreMessage extends AuthorizedFormRequest
{
//    protected function getRedirectUrl(): string
//    {
//        $url = $this->redirector->getUrlGenerator();
//
//        if ($this->isMethod('PATCH')) {
//            return $url->route('messages.edit', [
//                $this->route('project'),
//                $this->route('message'),
//            ]);
//        }
//
//        return $url->route('messages.create', $this->route('project'));
//    }

    public function rules(MessageRepository $messageRepository): array
    {
        $rules = [
            'name' => [
                'required',
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
