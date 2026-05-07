<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function admin_auth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $data = Admin::where('email', $request->email)->first();

        if ($data) {
            if (!Hash::check($request->password, $data->password)) {
                Alert::error('Error', 'Wrong Password');
                return back();
            } else {
                session()->put('admin_id', $data->id);
                session()->put('admin_email', $data->email);

                Alert::success('Success', 'Login Success');
                return redirect('/dashboard');
            }
        } else {
            Alert::error('Error', 'Email not found');
            return back();
        }
    }

    public function admin_logout()
    {
        session()->forget(['admin_id', 'admin_email']);
        return redirect('/');
    }

     public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Admin $admin)
    {
        //
    }

    public function edit(Admin $admin)
    {
        //
    }

    public function update(Request $request, Admin $admin)
    {
        //
    }

    public function destroy(Admin $admin)
    {
        //
    }
    
}

