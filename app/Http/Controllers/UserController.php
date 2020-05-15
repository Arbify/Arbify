<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Notifications\UserArtificiallyCreated;
use App\User;
use App\Utils\RandomPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index(): View
    {
        $users = User::paginate(30);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('users.form', [
            'generatedPassword' => RandomPassword::generate(12),
        ]);
    }

    public function store(StoreUser $request): Response
    {
        $user = User::create([
                'password' => Hash::make($request->input('password')),
            ] + $request->input());

        if ($request->input('email_verification')) {
            $user->markEmailAsVerified();
        }

        if ($request->input('send_credentials')) {
            $user->notify(
                new UserArtificiallyCreated($user->email, $request->input('password'))
            );
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
        if (empty($request->password)) {
            $request->offsetUnset('password');
        }
        $user->update([
                'password' => Hash::make($request->input('password')),
            ] + $request->input());

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
