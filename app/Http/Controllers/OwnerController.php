<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OwnerController extends Controller
{
    //
    public function dashboard()
    {
        $transaksis = Transaksi::whereNotNull('waktu_keluar')->latest()->get();
        return view('layouts.index', compact('transaksis'));
    }

    // DATA TRANSAKSI

    public function dataTransaksi()
    {
        // $transaksis = Transaksi::whereNotNull('waktu_keluar')->get();

        // $grouped = $transaksis->groupBy('waktu_keluar');

        // $total = $grouped->map(function ($items) {
        //     return $items->sum('biaya_total');
        // });

        $total = Transaksi::whereNotNull('waktu_keluar')->selectRaw('DATE(waktu_keluar) as tanggal, SUM(biaya_total) as total')->groupBy('tanggal')->orderBy('tanggal')->get();

        return response()->json([
            'labels' => $total->keys(),
            'values' => $total->values()
        ]);
    }

    public function data_transaksi(){
        $transaksis = Transaksi::whereNotNull('waktu_keluar')->latest()->get();

        return view('layouts.owner', compact('transaksis'));
    }

    public function excelExport(Request $request){
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => '📥 Mendownload Data Transaksi Masuk format EXCEL',
            'waktu_aktifitas' => now()
        ]);

        return Excel::download(
            new TransaksiExport($request->from, $request->to), 'Laporan Transaksi.xlsx'
        );
    }

    public function pdfExport(Request $request){
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = Carbon::parse($request->from)->startOfDay();
        $to = Carbon::parse($request->to)->endOfDay();

        $transaksis = Transaksi::with(['area', 'user'])->whereBetween('waktu_keluar',[
            $from,
            $to
        ])->get();

        $total = $transaksis->sum('biaya_total');


        $user = Auth::user();
        $user->log()->create([
            'aktifitas' => '📥 Mendownload Data Transaksi Masuk format PDF',
            'waktu_aktifitas' => now()
        ]);

        $pdf = Pdf::loadview('pdf.transaksi', compact('transaksis', 'from', 'to', 'total'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi.pdf');
    }
}
