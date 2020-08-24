<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Http\Controllers\BaseController;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Http\Requests\PutMessageValue;
use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use cogpowered\FineDiff\Diff;
use cogpowered\FineDiff\Granularity\Word;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageValueController extends BaseController
{
    private MessageValueRepository $messageValueRepository;
    private Diff $diff;

    public function __construct(MessageValueRepository $messageValueRepository)
    {
        $this->messageValueRepository = $messageValueRepository;
        $this->diff = new Diff(new Word());

        $this->middleware('verified');
    }

    public function put(
        PutMessageValue $request,
        Project $project,
        Message $message,
        Language $language,
        ?string $form = null
    ): Response {
        $this->authorize('putLanguage', [MessageValue::class, $project, $language]);
        $this->validateForm($form);

        $userId = $request->user()->id;

        $messageValue = $this->messageValueRepository->latest($message, $language, $form);
        // If message value exists, belongs to the current user and was updated in the last 20 seconds...
        if (
            $messageValue !== null && $messageValue->author !== null && $messageValue->author->id == $userId
            && $messageValue->updated_at->diffInSeconds(now()) < 20
        ) {
            $messageValue->update([
                'value' => unescapeWhitespace($request->input('message_value')),
            ]);

            return response($messageValue);
        }

        $messageValue = MessageValue::create([
            'message_id' => $message->id,
            'language_id' => $language->id,
            'form' => $form,
            'author_id' => $userId,
            'value' => unescapeWhitespace($request->input('message_value')),
        ]);

        return response($messageValue, Response::HTTP_CREATED);
    }

    public function history(
        Project $project,
        Message $message,
        Language $language,
        ?string $form = null
    ): array {
        $this->authorize('view', $project);
        $this->validateForm($form);

        $values = $this->messageValueRepository->history($message, $language, $form)->toArray();

        foreach ($values as $i => $value) {
            $a = escapeWhitespace($values[$i + 1]['value'] ?? '');
            $b = escapeWhitespace($value['value']);

            $values[$i] = array_merge($value, [
                'diff' => $this->diff->render($a, $b),
            ]);
        }

        return $values;
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
