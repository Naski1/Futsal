<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credential = $request->only('email', 'password');
        $messages = [
            'email.required'       => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
        ];

        $validator = Validator::make($credential, [
            'email' => 'required',
            'password' => 'required'
        ], $messages);

        if ($validator->fails()) {
            // return response()->json($validator->errors(), 422);
            return back()->withInput()->withErrors($validator);
        }

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            // return redirect()->route('pemesanan.harian');
            // if (Auth::user()->status == 'y') {
            return redirect()->intended('/');
            // } else {
            //     Auth::logout();
            //     $request->session()->invalidate();
            //     $request->session()->regenerateToken();
            //     return back()->withErrors(['message' => 'Akun tidak aktif silahkan hubungi admin']);
            // }
        }
        return back()->withErrors(['message' => 'Akun Salah / Tidak Ditemukan!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
