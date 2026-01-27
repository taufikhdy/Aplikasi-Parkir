<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

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
        $transaksis = Transaksi::whereNotNull('waktu_keluar')->get();

        $grouped = $transaksis->groupBy('waktu_keluar');

        $total = $grouped->map(function ($items) {
            return $items->sum('biaya_total');
        });

        return response()->json([
            'labels' => $total->keys(),
            'values' => $total->values()
        ]);
    }
}
