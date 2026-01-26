<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\LogAktifitas;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        $areas = AreaParkir::latest()->get();
        return view('layouts.index', compact('areas'));
    }

    public function form_area()
    {
        return view('layouts.form');
    }

    public function form_kendaraan()
    {
        return view('layouts.form');
    }

    public function tarif()
    {
        $tarifs = Tarif::get();
        return view('layouts.form', compact('tarifs'));
    }

    public function editTarif(Request $request)
    {
        $request->validate([
            'tarif_per_jam' => 'required|integer',
        ]);

        $tarif = Tarif::findOrFail($request->id_tarif);

        $tarif->update([
            'tarif_per_jam' => $request->tarif_per_jam
        ]);

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => 'Mengubah Harga Tarif ' . $tarif->jenis_kendaraan . ' ke Rp. ' . $tarif->tarif_per_jam,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->back()->with('success', 'Tarif Berhasil Diubah');
    }

    public function detail_area($id)
    {
        $area = AreaParkir::findOrFail($id);

        $area = AreaParkir::where('id_area', $id)->first();
        return view('layouts.area', compact('area'));
    }

    // BUAT AREA PARKIR BARU
    public function tambahArea(Request $request)
    {
        $request->validate([
            'nama_area' => 'string|required',
            'warna_label' => 'string|required|size:7',
            'kapasitas' => 'integer|required',
            // 'terisi' => 'integer',
            // 'jenis_kendaraan' => 'string|required',
            // 'tarif_per_jam' => 'required'
        ]);

        $post = AreaParkir::create([
            'nama_area' => $request->nama_area,
            'warna_label' => $request->warna_label,
            'kapasitas' => $request->kapasitas,
            'terisi' => 0
        ]);

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => 'Menambah Area Parkir : ' . $request->nama_area,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Area baru berhasil ditambahkan');
    }

    public function editArea(Request $request)
    {
        $request->validate([
            'nama_area' => 'string|required',
            'warna_label' => 'string|required|size:7',
            'kapasitas' => 'integer|required',
            // 'terisi' => 'integer',
            // 'jenis_kendaraan' => 'string|required',
            // 'tarif_per_jam' => 'required'
        ]);

        $area = AreaParkir::findOrFail($request->id_area);
        $area->update($request->all());

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => 'Mengubah Area Parkir (id=' . $area->id_area . ') ' . $request->nama_area,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function hapusArea($id)
    {
        $data = AreaParkir::findOrFail($id);
        $data->delete();

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => 'Menghapus Area Parkir : ' . $data->nama_area,
            'waktu_aktifitas' => now()
        ]);
        return redirect()->route('admin.dashboard');
    }

    public function users()
    {
        $users = User::latest()->get();

        return view('layouts.users', compact('users'));
    }

    public function tambahUser(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'string|required',
            'username' => 'string|required',
            'password' => 'string|required',
            'role' => 'string|required',
            'email' => 'string'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email' => 'revisi'
        ]);

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => 'Menambah User : ' . $request->nama_lengkap,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->back()->with('success', 'User Berhasil Ditambahkan');
    }

    public function hapusUser(Request $request)
    {
        $data = User::findOrFail($request->id_user);
        $data->delete();

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => 'Menghapus User : ' . $data->nama_lengkap,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }

    public function formEditUser($id){
        $user = User::findOrFail($id);
        return view('layouts.form', compact('user'));
    }

    public function editUser(Request $request){
        $request->validate([
            'nama_lengkap' => 'string|required',
            'username' => 'string|required',
            'role' => 'string|required'
        ]);

        $user = User::findOrFail($request->id_user);
        $user->update($request->all());

        $admin = Auth::user();
        $admin->log()->create([
            'aktifitas' => 'Mengubah Data ' . $user->nama_lengkap . '( ' . $user->username . ' )',
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.users')->with('success', 'Data User Berhasil Diubah');
    }


    public function detailLog($id)
    {
        $logs = LogAktifitas::where('id_user', $id)->latest()->get();

        return view('layouts.detailLog', compact('logs'));
    }
}
