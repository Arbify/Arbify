<?php

namespace App\Http\Controllers;

use App\Arb\ArbExporter;
use App\Contracts\Repositories\LanguageRepository;
use App\Contracts\Repositories\MessageValueRepository;
use App\Http\Requests\AddLanguageToProject;
use App\Http\Requests\ExportLanguage;
use App\Http\Requests\StoreProject;
use App\Models\Language;
use App\Models\Project;
use Illuminate\View\View;
use Storage;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index(): View
    {
        $projects = Project::paginate(15);

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    public function create(): View
    {
        $languages = Language::all();

        return view('projects.form', [
            'languages' => $languages,
        ]);
    }

    public function store(StoreProject $request): Response
    {
        $project = Project::create($request->input());

        return redirect()->route('projects.index')
            ->with('success', "Added <b>$project->name</b> successfully.");
    }

    public function show(Project $project): View
    {
        return view('projects.show', [
            'project' => $project,
        ]);
    }

    public function edit(Project $project): View
    {
        return view('projects.form', [
            'project' => $project,
        ]);
    }

    public function update(StoreProject $request, Project $project): Response
    {
        $project->update($request->input());

        return redirect()->route('projects.index')
            ->with('success', "Updated <b>$project->name</b> successfully.");
    }

    public function destroy(Project $project): Response
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', "Deleted <b>$project->name</b> successfully.");
    }

    public function createProjectLanguage(Project $project, LanguageRepository $languageRepository): View
    {
        $languages = $languageRepository->allExceptAlreadyInProject($project);

        return view('projects.add-language', [
            'project' => $project,
            'languages' => $languages,
        ]);
    }

    public function storeProjectLanguage(AddLanguageToProject $request, Project $project): Response
    {
        $language = Language::find($request->input('language'));

        $project->languages()->syncWithoutDetaching($language);

        return redirect()->route('messages.index', $project)
            ->with('success', "Added <b>$language->code</b> to <b>$project->name</b> successfully.");
    }

    public function destroyProjectLanguage(Project $project, Language $language): Response
    {
        $project->languages()->detach($language);

        return redirect()->route('messages.index', $project)
            ->with('success', "Deleted <b>$language->code</b> from <b>$project->name</b> successfully.");
    }

    public function export(Project $project): View
    {
        return view('projects.export', [
            'project' => $project,
        ]);
    }

    public function exportLanguage(
        ExportLanguage $request,
        Project $project,
        LanguageRepository $languageRepository,
        MessageValueRepository $messageValueRepository
    ): Response {
        $language = $languageRepository->byId($request->input('language'));
        $values = $messageValueRepository->byProjectAndLanguage($project, $language);

        $exporter = new ArbExporter();
        $result = $exporter->exportToArb($language->code, $values);

        $filename = "$language->code.arb";

        // Disable Debug bar so it doesn't add its HTML to our ARB file response...
        app('debugbar')->disable();

        return response($result, 200, [
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}
