<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return redirect('admin/users')->with('success', 'User blocked successfully');
    }

    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();

        return redirect('admin/users')->with('success', 'User unblocked successfully');
    }

    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.view', compact('user'));
    }
}
