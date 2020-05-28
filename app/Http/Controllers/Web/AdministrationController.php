<?php

namespace Arbify\Http\Controllers\Web;

use Arbify\Http\Controllers\Controller;
use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Contracts\Repositories\SettingsRepository;
use Arbify\Http\Requests\UpdateSettings;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AdministrationController extends Controller
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;

        $this->middleware('verified');
        $this->middleware('can:administration');
    }

    public function statistics(): View
    {
        return view('administration.statistics');
    }

    public function settings(LanguageRepository $languageRepository): View
    {
        $languages = $languageRepository->all();

        // Settings are provided via the Settings facade.
        return view('administration.settings', [
            'languages' => $languages,
        ]);
    }

    public function updateSettings(UpdateSettings $request): Response
    {
        $this->settingsRepository->saveAll($request->validated());

        return redirect()->route('administration.settings')
            ->with('success', 'Settings updated successfully.');
    }

    public function logs(): View
    {
        return view('administration.logs');
    }
}
