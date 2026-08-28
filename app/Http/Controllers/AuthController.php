<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address format.',
            'password.required' => 'Please enter your password.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $targetRoute = 'user.dashboard';
            if ($user->role === 'admin') {
                $targetRoute = 'admin.dashboard';
            } elseif ($user->role === 'moderator') {
                $targetRoute = 'moderator.dashboard';
            } elseif ($user->role === 'authority') {
                $targetRoute = 'authority.dashboard';
            }
            return redirect()->route($targetRoute)->with('success', 'Logged in successfully!');
        }

        return back()
            ->withErrors(['email' => 'Invalid email address or password. Please check your credentials and try again.'])
            ->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address format.',
            'email.unique' => 'This email address is already registered. Please sign in or use a different email address.',
            'phone.required' => 'Please enter your contact phone number.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 6 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'public_user',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to Safora.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
