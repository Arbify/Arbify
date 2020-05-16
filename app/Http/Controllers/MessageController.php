<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Http\Requests\PutMessageValue;
use App\Models\Language;
use App\Models\Message;
use App\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index(Project $project): View
    {
        return view('messages.index', [
            'project' => $project,
        ]);
    }

    public function create(Project $project): View
    {
        return view('messages.form', [
            'project' => $project,
        ]);
    }

    public function store(StoreMessage $request, Project $project): Response
    {
        $message = Message::create([
                'project_id' => $project->id,
            ] + $request->input());

        return redirect()->route('messages.index', $project)
            ->with('success', "Added <b>$message->name</b> successfully.");
    }

    public function edit(Project $project, Message $message): View
    {
        return view('messages.form', [
            'project' => $project,
            'message' => $message,
        ]);
    }

    public function update(StoreMessage $request, Project $project, Message $message): Response
    {
        $message->update($request->input());

        return redirect()->route('messages.index', $project)
            ->with('success', "Updated <b>$message->name</b> successfully.");
    }

    public function destroy(Project $project, Message $message): Response
    {
        $message->delete();

        return redirect()->route('messages.index', $project)
            ->with('success', "Deleted <b>$message->name</b> successfully.");
    }

    public function putMessageValue(
        PutMessageValue $request,
        Project $project,
        Message $message,
        Language $language
    ): Response {
        $value = $message->forLanguage($language, $request->input('form'));
        $value->fill([
            'value' => $request->input('value'),
            'language_id' => $language->id,
        ])->save();

        return $request->expectsJson() ?
            status( Response::HTTP_CREATED)
            : redirect()->route('messages.index', $project);
    }
}
