<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function showLoginForm(): View|Factory
    {
        return view('sign-in');
    }

    public function login(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->input('remember'))) {
            return redirect()->intended(route('dashboard'))->with('success', 'Berhasil Login');
        }
        return redirect()->back()->with('error', 'Email atau Password anda salah')->withInput();
    }

    public function logout(): Redirector|RedirectResponse
    {
        Auth::logout();
        return redirect('/login');
    }
}
