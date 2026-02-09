<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GeneralController extends Controller
{
    //
    public function ubahPassword(){
        return view('layouts.general.form');
    }

    public function newPassPost(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $id = Auth::user()->id_user;
        $user = User::findOrFail($id);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Password lama salah');
        }

        $user->password = Hash::make($request->new_password);

        $user->log()->create([
            'aktifitas' => '🗝️ Mengubah Kata Sandi',
            'waktu_aktifitas' => now()
        ]);

        $user->status_aktif = 0;
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
