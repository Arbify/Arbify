<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Http\Controllers\BaseController;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Http\Requests\PutMessageValue;
use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageValueController extends BaseController
{
    private MessageValueRepository $messageValueRepository;

    public function __construct(MessageValueRepository $messageValueRepository)
    {
        $this->messageValueRepository = $messageValueRepository;

        $this->middleware('verified');
    }

    public function put(
        PutMessageValue $request,
        Project $project,
        Message $message,
        Language $language,
        ?string $form = null
    ): Response {
        $this->validateForm($form);

        $this->messageValueRepository->byMessageLanguageAndFormOrCreate(
            $message,
            $language,
            $form
        )
            ->update($request->only('value'));

        return $request->expectsJson() ?
            status(Response::HTTP_CREATED)
            : redirect()->route('messages.index', $project);
    }

    private function validateForm(?string $form): void
    {
        if (
            null === $form || in_array($form, array_keys(Language::PLURAL_FORMS))
            || in_array($form, Language::GENDER_FORMS)
        ) {
            return;
        }

        throw new BadRequestHttpException('Given form is not valid');
    }
}
