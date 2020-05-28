<?php

namespace Arbify\Http\Controllers\Web\Project;

use Arbify\Http\Controllers\Controller;
use Arbify\Contracts\Repositories\MessageRepository;
use Arbify\Contracts\Repositories\MessageValueRepository;
use Arbify\Contracts\Repositories\ProjectRepository;
use Arbify\Http\Requests\StoreMessage;
use Arbify\Models\Message;
use Arbify\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
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

        $messageValues = $this->messageValueRepository->allByProjectAssociativeGrouped($project);
        $statistics = $this->projectRepository->translationStatistics($project);

        return view('projects.messages.index', [
            'project' => $project,
            'messageValues' => $messageValues,
            'statistics' => $statistics,
        ]);
    }

    public function create(Project $project): View
    {
        $this->authorize('create', [Message::class, $project]);

        return view('projects.messages.form', [
            'project' => $project,
        ]);
    }

    public function store(StoreMessage $request, Project $project): Response
    {
        $this->authorize('create', [Message::class, $project]);

        $message = Message::create([
                'project_id' => $project->id,
            ] + $request->validated());

        return redirect()->route('messages.index', $project)
            ->with('success', "Added <b>$message->name</b> successfully.");
    }

    public function edit(Project $project, Message $message): View
    {
        $this->authorize('update', [$message, $project]);

        return view('projects.messages.form', [
            'project' => $project,
            'message' => $message,
        ]);
    }

    public function update(StoreMessage $request, Project $project, Message $message): Response
    {
        $this->authorize('update', [$message, $project]);

        $message->update($request->validated());

        return redirect()->route('messages.index', $project)
            ->with('success', "Updated <b>$message->name</b> successfully.");
    }

    public function destroy(Project $project, Message $message): Response
    {
        $this->authorize('delete', [$message, $project]);

        $message->delete();

        return redirect()->route('messages.index', $project)
            ->with('success', "Deleted <b>$message->name</b> successfully.");
    }
}
