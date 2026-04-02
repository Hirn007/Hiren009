<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    // ✅ Show login page
    public function admin_login()
    {
        return view('admin.admin_login');
    }

    // ✅ Login Check
  public function loginCheck(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $admin = Admin::where('username', $request->username)->first();

    // ---- CASE 1: Admin does NOT exist → CREATE + LOGIN ----
    if (!$admin) {
        $newAdmin = Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        session([
            'admin_login' => true,
            'admin_id' => $newAdmin->id,
            'admin_username' => $newAdmin->username,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'New admin created & logged in');
    }

    // ---- CASE 2: Admin exists → check password ----
    if (!Hash::check($request->password, $admin->password)) {
        return back()->with('error', 'Wrong password');
    }

    // ---- CASE 3: Password correct → LOGIN ----
    session([
        'admin_login' => true,
        'admin_id' => $admin->id,
        'admin_username' => $admin->username,
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Login successful');
}

    // ✅ Dashboard
    public function dashboard()
{
    if (!session('admin_login')) {
        return redirect()->route('admin.login');
    }

    return view('admin.dashboard');
}

    // ✅ Logout
    public function admin_logout()
    {
        session()->forget(['admin_login', 'admin_id', 'admin_username']);

        return redirect()->route('admin.login')->with('success', 'Logout Successful');
    }
}