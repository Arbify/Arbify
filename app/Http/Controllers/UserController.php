<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\UserRepository;
use App\Http\Requests\StoreUser;
use App\Notifications\UserArtificiallyCreated;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Str;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->middleware('verified');
        $this->authorizeResource(User::class, 'user');
    }

    public function index(): View
    {
        $users = $this->userRepository->paginated();

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
            ->with('success', "User <b>$user->name</b> created successfully.");
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
            ->with('success', "User <b>$user->name</b> updated successfully.");
    }

    public function destroy(User $user): Response
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "User <b>$user->name</b> deleted successfully.");
    }
}
