<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Http\Controllers\Controller;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Http\Requests\PutMessageValue;
use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Symfony\Component\HttpFoundation\Response;

class MessageValueController extends Controller
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
        Language $language
    ): Response {
        $this->messageValueRepository->byMessageLanguageAndFormOrCreate(
            $message,
            $language,
            $request->input('form')
        )
            ->update($request->only('value'));

        return $request->expectsJson() ?
            status(Response::HTTP_CREATED)
            : redirect()->route('messages.index', $project);
    }
}
