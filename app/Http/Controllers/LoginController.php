<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
   public function login_tu()
   {
        return view('auth/login');
   }

   public function authenticate_tu(Request $request)
   {
      $this->validate($request, [
         'username'        => 'required',
         'password'        => 'required'
        //  'level'           => 'required',
        //  'institusi'       => 'required'
     ]);

     $credential = ['username' => $request->username, 'password' => $request->password];

            // dd($credential);
            if (Auth::attempt($credential)) {
            // if (Auth::attempt(request(['ni', 'password']))) {
            // if (Auth::attempt(['ni' => $request->ni, 'level' => $request->level, 'password' => 12345678])) {
                // return "Berhasil Login";
                return redirect()->route('home');
            }else
            return redirect()->back()->with('error', 'Username atau Password salah');
   }

   public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('auth/login');
    }
}
