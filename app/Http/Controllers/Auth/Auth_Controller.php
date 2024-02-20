<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Auth_Controller extends Controller
{
    public function authenticate_tu(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $credential = ['username' => $request->username, 'password' => $request->password];

        if (Auth::attempt($credential)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error', 'Username atau Password salah');
        }
    }

    public function registrasi_store(Request $request)
    {
        $request->validate([
            'username'  => 'required|unique:users',
            'level'     => 'required',
            'institusi' => 'required',
            'password'  => 'required',
        ]);

        $user = new User([
            'username'     => $request->username,
            'level'        => $request->level,
            'institusi'    => $request->institusi,
            'password'     => Hash::make($request->password),
        ]);
        $user->save();

        return redirect('auth/registrasi')->with('success', 'Registration success. Please login!');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('auth/login');
    }
}
