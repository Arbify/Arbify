<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\SecretRepository;
use App\Http\Requests\CreateSecret;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken as Secret;
use Symfony\Component\HttpFoundation\Response;

class SecretController extends Controller
{
    private SecretRepository $secretRepository;

    public function __construct(SecretRepository $secretRepository)
    {
        $this->secretRepository = $secretRepository;

        $this->middleware('verified');
        $this->authorizeResource(Secret::class, 'secret');
    }

    protected function resourceAbilityMap(): array
    {
        return [
            'index' => 'viewAny',
            'create' => 'create',
            'store' => 'create',
            'revoke' => 'revoke',
        ];
    }

    public function index(Request $request): View
    {
        $secrets = $this->secretRepository->allByUser($request->user());

        return view('account.secrets.index', [
            'secrets' => $secrets,
        ]);
    }

    public function create(): View
    {
        return view('account.secrets.create');
    }

    public function store(CreateSecret $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $newSecret = $user->createToken($request->input('name'));
        $newSecretValue = explode('|', $newSecret->plainTextToken, 2)[1];

        $message = "<p>Secret <b>{$newSecret->accessToken->name}</b> created successfully. Keep it safe, " .
            "you will not be able to see this secret again.</p><p class=\"mb-0 d-flex align-items-baseline\">" .
            "<span class=\"text-nowrap mr-2\">Your secret is</span>" .
            "<input class=\"form-control d-inline-block\" style=\"width: \" value=\"$newSecretValue\" readonly>";

        return redirect()->route('account-secrets.index')
            ->with('success', $message);
    }

    public function revoke(Secret $secret): Response
    {
        $secret->delete();

        return redirect()->route('account-secrets.index')
            ->with('success', "Revoked <b>$secret->name</b> successfully.");
    }
}
