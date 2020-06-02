<?php

namespace Arbify\Http\Controllers\Web;

use Arbify\Http\Controllers\BaseController;
use Arbify\Contracts\Repositories\LanguageRepository;
use Arbify\Contracts\Repositories\SettingsRepository;
use Arbify\Http\Requests\UpdateSettings;
use Arbify\Models\Language;
use Arbify\Models\Message;
use Arbify\Models\MessageValue;
use Arbify\Models\Project;
use Arbify\Models\User;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken as Secret;
use Symfony\Component\HttpFoundation\Response;

class AdministrationController extends BaseController
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
        $numbers = [
            'users' => User::count(),
            'languages' => Language::count(),
            'projects' => Project::count(),
            'messages' => Message::count(),
            'message_values' => MessageValue::count(),
            'secrets' => Secret::count(),
        ];

        return view('administration.statistics', [
            'numbers' => $numbers,
        ]);
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
