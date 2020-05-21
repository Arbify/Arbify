<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\LanguageRepository;
use App\Http\Requests\StoreLanguage;
use App\Models\Language;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    private LanguageRepository $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;

        $this->middleware('verified');
        $this->authorizeResource(Language::class);
    }

    public function index(): View
    {
        $languages = $this->languageRepository->allPaginated();

        return view('languages.index', [
            'languages' => $languages,
        ]);
    }

    public function create(): View
    {
        return view('languages.form');
    }

    public function store(StoreLanguage $request): Response
    {
        $language = Language::create($request->input());

        return redirect()->route('languages.index')
            ->with('success', "Added <b>$language->code</b> successfully.");
    }

    public function edit(Language $language): View
    {
        return view('languages.form', [
            'language' => $language,
        ]);
    }

    public function update(StoreLanguage $request, Language $language): Response
    {
        $language->update($request->input());

        return redirect()->route('languages.index')
            ->with('success', "Updated <b>$language->code</b> successfully.");
    }

    public function destroy(Language $language): Response
    {
        $language->delete();

        return redirect()->route('languages.index')
            ->with('success', "Deleted <b>$language->code</b> successfully.");
    }
}
