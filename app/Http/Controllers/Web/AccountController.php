<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePassword;
use Hash;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function preferences(Request $request): View
    {
        return view('account.preferences');
    }

    public function updatePreferences(Request $request): Response
    {
        return back();
    }

    public function changePassword(): View
    {
        return view('account.change-password');
    }

    public function updatePassword(UpdatePassword $request): Response
    {
        $user = $request->user();

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->route('account.change-password')
                ->withErrors(['old_password' => 'Your old password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
