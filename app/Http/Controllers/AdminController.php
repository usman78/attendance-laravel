<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('dashboard');
        }

        Log::info($request->all());

        // dd(Auth::guard('admin')->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]));

        // if (Auth::guard('admin')->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ], $request->remember)) {
        //     dd(Auth::guard('admin')->user());
        //     return redirect()->route('dashboard'); // Redirect on success
        // }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
