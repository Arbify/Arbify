<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Message;
use App\Project;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        return view('messages.index', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        return view('messages.form', [
            'project' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessage $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessage $request, Project $project)
    {
        if (!$request->validated()) {
            return redirect('messages.create')
                ->withErrors($request)
                ->withInput();
        }

        $message = new Message();
        $message->name = $request->name;
        $message->description = $request->description;
        $message->type = $request->type;
        $message->project_id = $project->id;
        $message->save();

        return redirect()->route('messages.index', $project)
            ->with('success', "Added <b>$message->name</b> successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @param  \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Message $message)
    {
        return view('messages.form', [
            'project' => $project,
            'message' => $message,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreMessage $request
     * @param  \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMessage $request, Project $project, Message $message)
    {
        if (!$request->validated()) {
            return redirect()->route('messages.edit')
                ->withErrors($request)
                ->withInput();
        }

        $message->name = $request->name;
        $message->description = $request->description;
        $message->save();

        return redirect()->route('messages.index', $project)
            ->with('success', "Updated <b>$message->name</b> successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Message $message)
    {
        $message->delete();

        return redirect()->route('messages.index', $project)
            ->with('success', "Deleted <b>$message->name</b> successfully.");
    }
}
