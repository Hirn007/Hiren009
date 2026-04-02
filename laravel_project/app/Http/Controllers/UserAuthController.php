<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserAuthController extends Controller
{
    // SHOW LOGIN PAGE
    public function login()
    {
        return view('website.login');
    }

    // LOGIN CHECK
    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect('/'); // Home page
        } else {
            return back()->with('error', 'Invalid Email or Password');
        }
    }

    // SHOW SIGNUP PAGE (OPTIONAL IF ROUTE IS DIRECT)
    public function signUp()
    {
        return view('website.sign-up');
    }

    // REGISTER NEW USER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/login')->with('success', 'Account created');
    }

    // LOGOUT USER
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}