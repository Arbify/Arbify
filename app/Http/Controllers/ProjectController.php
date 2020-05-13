<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddLanguageToProject;
use App\Http\Requests\StoreProject;
use App\Language;
use App\Project;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(15);

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::all();

        return view('projects.form', [
            'languages' => $languages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProject $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {
        if (!$request->validated()) {
            return redirect('projects.create')
                ->withErrors($request)
                ->withInput();
        }

        $project = new Project();
        $project->name = $request->name;
        $project->save();

        return redirect()->route('projects.index')
            ->with('success', "Added <b>$project->name</b> successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.form', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProject $request, Project $project)
    {
        if (!$request->validated()) {
            return redirect()->route('projects.edit')
                ->withErrors($request)
                ->withInput();
        }

        $project->name = $request->name;
        $project->save();

        return redirect()->route('projects.index')
            ->with('success', "Updated <b>$project->name</b> successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', "Deleted <b>$project->name</b> successfully.");
    }

    public function addLanguage(Project $project)
    {
        $languages = Language::allExceptAlreadyInProject($project);

        return view('projects.add-language', [
            'project' => $project,
            'languages' => $languages,
        ]);
    }

    public function postAddLanguage(AddLanguageToProject $request, Project $project)
    {
        if (!$request->validated()) {
            return redirect()->route('messages.index', $project)
                ->withErrors($request)
                ->withInput();
        }

        $language = Language::find($request->language);

        $project->languages()->syncWithoutDetaching($language);

        return redirect()->route('messages.index', $project)
            ->with('success', "Added <b>$language->code</b> to <b>$project->name</b> successfully.");
    }
}
