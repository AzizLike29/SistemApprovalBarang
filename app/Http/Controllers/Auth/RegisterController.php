<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.RegisterForm');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:191', 'unique:users,email'],
            'password'  => ['required', 'min:8'],
        ]);

        $user = User::create([
            'nama'      => $data['nama'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
        ]);

        // Setelah registrasi berhasil, redirect ke halaman login
        return redirect()->route('login')->with('success', 'Registrasi berhasil');
    }
}
