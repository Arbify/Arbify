<?php

namespace Arbify\Http\Controllers\Web\Auth;

use Arbify\Http\Controllers\BaseController;
use Arbify\Providers\RouteServiceProvider;
use Arbify\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Settings;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegisterController extends BaseController
{
    use RedirectsUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(): View
    {
        $this->checkRegistrationEnabled();

        return view('auth.register');
    }

    public function register(Request $request): Response
    {
        $this->checkRegistrationEnabled();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        event(new Registered($user));

        Auth::guard()->login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    private function checkRegistrationEnabled(): void
    {
        if (!Settings::registrationEnabled()) {
            throw new NotFoundHttpException();
        }
    }
}
