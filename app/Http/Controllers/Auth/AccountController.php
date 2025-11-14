<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function showAccountForm()
    {
        $id = Auth::user()->id_users;
        $users = User::where('id_users', $id)->get();
        $link = "user";
        return view('auth.AccountForm', compact('link', 'users'));
    }

    public function editAccount(Request $request, $id)
    {
        $user = User::find($id);
        // Update data user
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->no_telp = $request->no_telp;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('accountForm')->with('success', 'Data Akun berhasil dirubah!');
    }
}
