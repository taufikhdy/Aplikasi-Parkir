<?php

namespace App\Http\Controllers;

use App\Imports\KendaraanImport;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktifitas;
use App\Models\Tarif;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\PDF;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        $logs = LogAktifitas::latest()->take(10)->get();
        $areas = AreaParkir::latest()->get();
        return view('layouts.index', compact('areas', 'logs'));
    }

    public function form_area()
    {
        return view('layouts.admin.form');
    }

    public function form_kendaraan()
    {
        return view('layouts.admin.form');
    }

    public function tarif()
    {
        $tarifs = Tarif::get();
        return view('layouts.admin.form', compact('tarifs'));
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
            'aktifitas' => '✏️ Mengubah Harga Tarif ' . $tarif->jenis_kendaraan . ' ke Rp. ' . $tarif->tarif_per_jam,
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
            'aktifitas' => '🅿️ Menambah Area Parkir : ' . $request->nama_area,
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
            'aktifitas' => '✏️ Mengubah Area Parkir (id=' . $area->id_area . ') ' . $request->nama_area,
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
            'aktifitas' => '🗑️ Menghapus Area Parkir : ' . $data->nama_area,
            'waktu_aktifitas' => now()
        ]);
        return redirect()->route('admin.dashboard');
    }

    public function users()
    {
        $users = User::latest()->get();

        return view('layouts.admin.users', compact('users'));
    }

    public function formUser()
    {
        return view('layouts.admin.form');
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
            'aktifitas' => '➕ Menambah User : ' . $request->nama_lengkap,
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
            'aktifitas' => '🗑️ Menghapus User : ' . $data->nama_lengkap,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }

    public function formEditUser($id)
    {
        $user = User::findOrFail($id);
        return view('layouts.admin.form', compact('user'));
    }

    public function editUser(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'string|required',
            'username' => 'string|required',
            'role' => 'string|required'
        ]);

        $user = User::findOrFail($request->id_user);
        $user->update($request->all());

        $admin = Auth::user();
        $admin->log()->create([
            'aktifitas' => '✏️ Mengubah Data ' . $user->nama_lengkap . '( ' . $user->username . ' )',
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.users')->with('success', 'Data User Berhasil Diubah');
    }

    public function aktifitas()
    {
        $logs = LogAktifitas::latest()->get();
        return view('layouts.admin.aktivitas', compact('logs'));
    }

    public function detailLog($id)
    {
        $logs = LogAktifitas::where('id_user', $id)->latest()->get();

        return view('layouts.admin.detailLog', compact('logs'));
    }

    public function hapusLog()
    {
        LogAktifitas::truncate();

        $admin = Auth::user();
        $admin->log()->create([
            'aktifitas' => '🗑️ ' . $admin->nama_lengkap . ' Menghapus Seluruh Data Log Aktivitas User',
            'waktu_aktifitas' => now()
        ]);
        return redirect()->route('admin.aktivitas')->with('success', 'Log Aktivitas Berhasil Dibersihkan');
    }

    public function exportLogPdf(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = Carbon::parse($request->from)->startOfDay();
        $to = Carbon::parse($request->to)->endOfDay();

        $logs = LogAktifitas::whereBetween('created_at', [
            $from,
            $to
        ])->latest()->get();


        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => '📥 Mendownload Data Aktivitas User format PDF',
            'waktu_aktifitas' => now()
        ]);

        $pdf = Pdf::loadview('pdf.logAktifitas', compact('logs', 'from', 'to'))->setPaper('a4', 'landscape');

        return $pdf->download('Rekap Data Aktivitas Pengguna.pdf');
    }

    public function member()
    {
        $kendaraan = Kendaraan::latest()->get();
        return view('layouts.member', compact('kendaraan'));
    }

    public function memberForm()
    {
        return view('layouts.admin.form');
    }

    public function memberFormPost(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'plat_nomor' => 'required|string',
            'pemilik' => 'required|string',
            'jenis_kendaraan' => 'required|string',
            'warna_kendaraan' => 'required|string'
        ]);

        Kendaraan::create([
            'plat_nomor' => $request->plat_nomor,
            'pemilik' => $request->pemilik,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna_kendaraan,
            'id_user' => $request->id_user
        ]);

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => '👑 Menambah Member ' . $request->jenis_kendaraan . ' Plat Nomor : ' . $request->plat_nomor,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.member');
    }

    public function memberFormEdit($id)
    {
        $member = Kendaraan::findOrFail($id);

        return view('layouts.admin.form', compact('member'));
    }

    public function memberEditPost(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required',
            'jenis_kendaraan' => 'required',
            'warna_kendaraan' => 'required',
            'pemilik' => 'required'
        ]);

        $member = Kendaraan::findOrFail($request->id_kendaraan);
        $member->update([
            'plat_nomor' => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna_kendaraan,
            'pemilik' => $request->pemilik
        ]);
        // $member->update($request->all());

        $admin = Auth::user();
        $admin->log()->create([
            'aktifitas' => '✏️ Mengubah Data Member ' . $member->pemilik . ' (' . $member->plat_nomor . ')',
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.member')->with('success', 'Data Member Berhasil Diubah');
    }

    public function memberHapus(Request $request)
    {
        $member = Kendaraan::findOrFail($request->id_kendaraan);
        $member->delete();

        $admin = Auth::user();
        $admin->log()->create([
            'aktifitas' => '🗑️ Menghapus Data Member ' . $member->pemilik . ' (' . $member->plat_nomor . ')',
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.member');
    }

    public function memberHapusAll()
    {
        Kendaraan::query()->delete();

        $admin = Auth::user();
        $admin->log()->create([
            'aktifitas' => '🗑️ ' . $admin->nama_lengkap . ' Menghapus Seluruh Data Member',
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.member')->with('success', 'Seluruh Data Member Berhasil dihapus');
    }

    public function importMember(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(
            new KendaraanImport(
                Auth::user()->id_user
            ),
            $request->file('file')
        );

        $admin = Auth::user();
        $admin->log()->create([
            'aktifitas' => '📚 Mengimpor Data Member ',
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('admin.member');
    }
}
