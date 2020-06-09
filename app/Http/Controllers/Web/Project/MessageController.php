<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Http\Controllers\BaseController;
use Arbify\Contracts\Repositories\MessageRepository;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Contracts\Repositories\ProjectRepository;
use Arbify\Http\Requests\StoreMessage;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends BaseController
{
    private ProjectRepository $projectRepository;
    private MessageRepository $messageRepository;
    private MessageValueRepository $messageValueRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        MessageRepository $messageRepository,
        MessageValueRepository $messageValueRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->messageRepository = $messageRepository;
        $this->messageValueRepository = $messageValueRepository;

        $this->middleware('verified');
    }

    public function index(Project $project): View
    {
        $this->authorize('view-any', [Message::class, $project]);

        return view('projects.messages.index', ['project' => $project]);
    }

    public function indexData(Project $project): array
    {
        $this->authorize('view-any', [Message::class, $project]);

        $statistics = $this->projectRepository->translationStatistics($project);
        $languages = $project->languages->toArray();
        foreach ($languages as $i => $language) {
            $languages[$i] = array_merge($language, [
                'stats' => [
                    'all' => $statistics[$language['code']]['all'],
                    'translated' => $statistics[$language['code']]['translated'],
                ],
            ]);

            if ($language['flag']) {
                $languages[$i]['flag'] = asset("storage/flags/{$language['flag']}.svg");
            }
        }

        $messages = $project->messages->toArray();
        $values = $this->messageValueRepository->allByProject($project);

        return [
            'languages' => $languages,
            'messages' => $messages,
            'values' => $values,
        ];
    }

    public function store(StoreMessage $request, Project $project): Message
    {
        $this->authorize('create', [Message::class, $project]);

        return Message::create([
                'project_id' => $project->id,
            ] + $request->validated());
    }

    public function update(StoreMessage $request, Project $project, Message $message): Message
    {
        $this->authorize('update', [$message, $project]);

        $message->update($request->validated());

        return $message;
    }

    public function destroy(Project $project, Message $message): Response
    {
        $this->authorize('delete', [$message, $project]);

        $message->delete();

        return status(Response::HTTP_NO_CONTENT);
    }
}
