<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\MessageValueRepository;
use App\Http\Requests\PutMessageValue;
use App\Models\Language;
use App\Models\Message;
use App\Models\Project;
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
            ->update(['value' => $request->input('value')]);

        return $request->expectsJson() ?
            status(Response::HTTP_CREATED)
            : redirect()->route('messages.index', $project);
    }
}
