<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registrasi()
    {
        return view('auth/registrasi');
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
}
