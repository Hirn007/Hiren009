<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller 
{
    // LOGIN PAGE
    public function admin_login()
    {
        if (session()->has('admin_login')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.admin_login');
    }

    // LOGIN CHECK
    public function loginCheck(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        // Case 1: New Admin Create
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

        // Case 2: Password Check
        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Wrong password');
        }

        // Case 3: Login
        session([
            'admin_login' => true,
            'admin_id' => $admin->id,
            'admin_username' => $admin->username,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Login successful');
    }

    // DASHBOARD
    public function dashboard()
    {
        if (!session('admin_login')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard');
    }

    // LOGOUT
    public function admin_logout()
    {
        session()->forget(['admin_login', 'admin_id', 'admin_username']);
        return redirect()->route('admin.login')->with('success', 'Logout Successful');
    }

    // SHOW ALL USERS
    public function userManagement()
    {
        $users = User::all();
        return view('admin.user_management', compact('users'));
    }

    // SHOW BLOCKED USERS
    public function blockedUsers()
    {
        $users = User::where('status', 0)->get();
        return view('admin.user_management', compact('users'));
    }

    // BLOCK USER
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return redirect('admin/users')->with('success', 'User blocked successfully');
    }

    // UNBLOCK USER
    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();

        return redirect('admin/users')->with('success', 'User unblocked successfully');
    }

    // VIEW USER
    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.view', compact('user'));
    }
}