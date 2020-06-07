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
        $this->authorize('put', [MessageValue::class, $project, $message, $language]);
        $this->validateForm($form);

        $userId = $request->user()->id;

        $messageValue = $this->messageValueRepository->latest($message, $language, $form);
        // If message value exists, belongs to the current user and was updated in the last 3 minutes...
        if ($messageValue !== null && $messageValue->author !== null && $messageValue->author->id == $userId
            && $messageValue->updated_at->diffInMinutes(now()) < 3) {
            $messageValue->update($request->only('value'));
        } else {
            MessageValue::create([
                'message_id' => $message->id,
                'language_id' => $language->id,
                'form' => $form,
                'author_id' => $userId,
                'value' => $request->input('value'),
            ]);
        }

        return $request->expectsJson() ?
            status(Response::HTTP_CREATED)
            : redirect()->route('messages.index', $project);
    }

    public function history(
        Request $request,
        Project $project,
        Message $message,
        Language $language
    ): View {
        $this->authorize('view', $project);

        $form = $request->query('form');
        $this->validateForm($form);

        $values = $this->messageValueRepository->history($message, $language, $form);

        return view('projects.messages.history', [
            'project' => $project,
            'message' => $message,
            'language' => $language,
            'form' => $form,
            'values' => $values,
            'diff' => $this->diff,
        ]);
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
