<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Contracts\Repositories\CountryFlagRepository;
use App\Contracts\Repositories\LanguageRepository;
use App\Http\Requests\StoreLanguage;
use App\Models\Language;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends Controller
{
    private LanguageRepository $languageRepository;
    private CountryFlagRepository $countryFlagRepository;

    public function __construct(
        LanguageRepository $languageRepository,
        CountryFlagRepository $countryFlagRepository
    ) {
        $this->languageRepository = $languageRepository;
        $this->countryFlagRepository = $countryFlagRepository;

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
        $countryFlags = $this->countryFlagRepository->getAllFlags();

        return view('languages.form', [
            'countryFlags' => $countryFlags,
        ]);
    }

    public function store(StoreLanguage $request): Response
    {
        $language = Language::create($request->validated());

        return redirect()->route('languages.index')
            ->with('success', "Added <b>$language->code</b> successfully.");
    }

    public function edit(Language $language): View
    {
        $countryFlags = $this->countryFlagRepository->getAllFlags();

        return view('languages.form', [
            'language' => $language,
            'countryFlags' => $countryFlags,
        ]);
    }

    public function update(StoreLanguage $request, Language $language): Response
    {
        $language->update($request->validated());

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
