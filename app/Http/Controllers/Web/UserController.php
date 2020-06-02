<?php

namespace Arbify\Http\Controllers\Web;

use Arbify\Http\Controllers\BaseController;
use Arbify\Contracts\Repositories\UserRepository;
use Arbify\Http\Requests\StoreUser;
use Arbify\Notifications\UserArtificiallyCreated;
use Arbify\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Str;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->middleware('verified');
        $this->authorizeResource(User::class);
    }

    public function index(): View
    {
        $users = $this->userRepository->allPaginated();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('users.form', [
            'generatedPassword' => Str::random(12),
        ]);
    }

    public function store(StoreUser $request): Response
    {
        $user = User::create([
                'password' => Hash::make($request->input('password')),
            ] + $request->validated());

        if ($request->input('email_verification')) {
            $user->markEmailAsVerified();
        }

        if ($request->input('send_credentials')) {
            $user->notify(new UserArtificiallyCreated(
                $user->email,
                $request->input('password')
            ));
        }

        event(new Registered($user));

        return redirect()->route('users.index')
            ->with('success', "User <b>$user->username</b> created successfully.");
    }

    public function edit(User $user): View
    {
        return view('users.form', [
            'user' => $user,
        ]);
    }

    public function update(StoreUser $request, User $user): Response
    {
        $input = $request->except('password');
        if (!empty($request->input('password'))) {
            $input['password'] = Hash::make($request->input('password'));
        }

        $user->update($input);

        return redirect()->route('users.index')
            ->with('success', "User <b>$user->username</b> updated successfully.");
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "User <b>$user->username</b> deleted successfully.");
    }
}
