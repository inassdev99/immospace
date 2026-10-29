<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    public function registerForm()
    {
        if (Auth::check()) {
            return $this->redirectToAccount();
        }

        return view('client-auth', [
            'mode' => 'register',
        ]);
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectToAccount();
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'max:128', 'confirmed'],
        ]);

        $user = new User();

        $user->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ])->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('client.account')
            ->with('success', 'Votre compte a été créé avec succès.');
    }

    public function loginForm()
    {
        if (Auth::check()) {
            return $this->redirectToAccount();
        }

        return view('client-auth', [
            'mode' => 'login',
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectToAccount();
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'Email ou mot de passe incorrect.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectToAccount();
    }

    public function account()
    {
        if (! Auth::check()) {
            return redirect()->route('client.login');
        }

        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('client-auth', [
            'mode' => 'account',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login');
    }

    private function redirectToAccount()
    {
        return redirect()->route(
            Auth::user()->is_admin
                ? 'admin.dashboard'
                : 'client.account'
        );
    }
}