<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LogAktifitas;

class AuthController extends Controller
{
    //
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        // $remember = $request->has('remember');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $user->status_aktif = 1;
            $user->save();

            $user->log()->create([
                'aktifitas' => 'Login Aplikasi',
                'waktu_aktifitas' => now()
            ]);

            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'petugas' => redirect()->route('petugas.dashboard'),
                'owner' => redirect()->route('owner.dashboard'),
                default => redirect()->route('login')
            };
        }
        return redirect()->route('login')->with('error', 'Login gagal');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => 'Logout Aplikasi',
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
