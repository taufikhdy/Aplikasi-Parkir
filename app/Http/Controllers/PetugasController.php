<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Carbon\Carbon;

class PetugasController extends Controller
{
    //
    public function dashboard()
    {
        $areas = AreaParkir::latest()->get();
        return view('layouts.index', compact('areas'));
    }

    public function detail_area($id)
    {
        $area = AreaParkir::findOrFail($id);
        $kendaraan = Transaksi::where('id_area', $id)->where('status', 'masuk')->latest()->get();
        return view('layouts.area', compact('area', 'kendaraan'));
    }

    public function tambahTransaksi($id){
        $kendaraan = Kendaraan::findOrFail($id);

        $areas = AreaParkir::whereColumn('terisi', '<', 'kapasitas')->get();
        return view('layouts.petugas.formPetugas', compact('areas', 'kendaraan'));
    }

    public function tambahTransaksiPost(Request $request){
        $request->validate([
            'plat_nomor' => 'string|required',
            'pemilik' => 'string',
            'jenis_kendaraan' => 'string|required',
            'waktu_masuk' => 'date|required',
            'warna_kendaraan' => 'string',
            'id_area' => 'required|exists:area_parkir,id_area',
            'id_user' => 'required|exists:users,id_user',
            'id_kendaraan' => 'required|exists:kendaraan,id_kendaraan'
        ]);

        $area = AreaParkir::where('id_area', $request->id_area)->whereColumn('terisi', '<', 'kapasitas')->increment('terisi');

        if ($request->jenis_kendaraan === 'motor') {
            $tarif = Tarif::where('jenis_kendaraan', 'motor')->first();
        } elseif ($request->jenis_kendaraan === 'mobil') {
            $tarif = Tarif::where('jenis_kendaraan', 'mobil')->first();
        } elseif ($request->jenis_kendaraan === 'lainnya') {
            $tarif = Tarif::where('jenis_kendaraan', 'lainnya')->first();
        }

        $tb_transaksi = Transaksi::create([
            'id_kendaraan' => $request->id_kendaraan,
            'waktu_masuk' => $request->waktu_masuk,
            'waktu_keluar' => $request->waktu_masuk, //VALUE UNTUK WAKTU KELUAR
            'id_tarif' => $tarif->id_tarif,
            'status' => 'masuk',
            'id_user' => $request->id_user,
            'id_area' => $request->id_area
        ]);

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => '➕ Menambah Transaksi Masuk Plat Nomor : ' . $request->plat_nomor,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('petugas.struk', $tb_transaksi->id_parkir);

    }

    public function tambahCustomer()
    {
        $areas = AreaParkir::whereColumn('terisi', '<', 'kapasitas')->get();
        return view('layouts.petugas.formPetugas', compact('areas'));
    }

    public function tambahCustomerPost(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'string|required',
            'pemilik' => 'string',
            'jenis_kendaraan' => 'string|required',
            'waktu_masuk' => 'date|required',
            'warna_kendaraan' => 'string',
            'id_area' => 'required|exists:area_parkir,id_area',
            'id_user' => 'required|exists:users,id_user'
        ]);

        $tb_kendaraan = Kendaraan::create([
            'plat_nomor' => $request->plat_nomor,
            'pemilik' => $request->pemilik,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna_kendaraan,
            'id_user' => $request->id_user
        ]);

        $area = AreaParkir::where('id_area', $request->id_area)->whereColumn('terisi', '<', 'kapasitas')->increment('terisi');

        if ($tb_kendaraan->jenis_kendaraan === 'motor') {
            $tarif = Tarif::where('jenis_kendaraan', 'motor')->first();
        } elseif ($tb_kendaraan->jenis_kendaraan === 'mobil') {
            $tarif = Tarif::where('jenis_kendaraan', 'mobil')->first();
        } elseif ($tb_kendaraan->jenis_kendaraan === 'lainnya') {
            $tarif = Tarif::where('jenis_kendaraan', 'lainnya')->first();
        }

        $tb_transaksi = Transaksi::create([
            'id_kendaraan' => $tb_kendaraan->id_kendaraan,
            'waktu_masuk' => $request->waktu_masuk,
            'waktu_keluar' => null,
            'id_tarif' => $tarif->id_tarif,
            'status' => 'masuk',
            'id_user' => $tb_kendaraan->id_user,
            'id_area' => $request->id_area
        ]);

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => '➕ Menambah Pelanggan ' . $request->jenis_kendaraan . ' Plat Nomor : ' . $request->plat_nomor,
            'waktu_aktifitas' => now()
        ]);

        return redirect()->route('petugas.struk', $tb_transaksi->id_parkir);
    }


    public function customerList()
    {
        $customers = Transaksi::where('status', 'masuk')->latest()->get();

        return view('layouts.petugas.customers', compact('customers'));
    }

    public function memberList(){
        $member = Kendaraan::with('transaksiTerakhir')->latest()->get();

        return view('layouts.member', compact('member'));
    }

    public function pelangganFormSelesai($id_parkir)
    {
        $transaksi = Transaksi::findOrFail($id_parkir);

        return view('layouts.petugas.formPetugas', compact('transaksi'));
    }

    public function pelangganSelesaiPost(Request $request)
    {
        $request->validate([
            'id_parkir' => 'required|exists:transaksi,id_parkir',
            'waktu_masuk' => 'required|date',
            'waktu_keluar' => 'required|date',
            'tarif_per_jam' => 'integer|required'
        ]);


        $masuk = Carbon::parse($request->waktu_masuk);
        $keluar = Carbon::parse($request->waktu_keluar);

        $menit = $masuk->diffInMinutes($keluar);
        $jam = ceil($menit / 60);

        if ($menit <= 30) {
            $biaya = $request->tarif_per_jam / 2;
            $jam = -1;
        } else {
            $biaya = $request->tarif_per_jam * $jam;
        }

        $transaksi = Transaksi::findOrFail($request->id_parkir);

        $transaksi->update([
            'waktu_keluar' => $request->waktu_keluar,
            'durasi_jam' => $jam,
            'biaya_total' => $biaya,
            'status' => 'keluar',
            'id_user' => Auth::user()->id_user
        ]);


        $area = AreaParkir::where('id_area', $transaksi->id_area)->where('terisi', '>', 0)->decrement('terisi');

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => '✅ Mengkonfirmasi Pelanggan ' . $transaksi->kendaraan->pemilik . ' ' . $transaksi->kendaraan->plat_nomor . ' Selesai',
            'waktu_aktifitas' => now()
        ]);

        // Kendaraan::where('id_kendaraan', $transaksi->id_kendaraan)->delete();

        return redirect()->route('petugas.struk', $request->id_parkir);
    }

    public function struk($id_parkir){
        $transaksi = Transaksi::findOrFail($id_parkir);
        return view('layouts.petugas.struk', compact('transaksi'));
    }
}
